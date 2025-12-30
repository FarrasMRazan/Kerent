<?php

namespace App\Http\Controllers;

use App\Models\Clothe;
use App\Models\Rental;
use App\Models\Cart;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class RentalController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function checkout(Request $request)
    {
        try {
            $user = Auth::user();
            if (empty($user->address)) return response()->json(['error' => 'Alamat belum lengkap'], 422);

            $cartItems = Cart::with('clothe')->where('user_id', $user->id)->get();
            if ($cartItems->isEmpty()) return response()->json(['error' => 'Keranjang kosong'], 400);

            $totalPrice = $cartItems->sum(function($item) {
                $days = max(1, Carbon::parse($item->start_date)->diffInDays(Carbon::parse($item->end_date)));
                return $item->clothe->price_per_day * $days;
            });

            $orderId = 'KRENT-' . time() . $user->id;

            return DB::transaction(function () use ($cartItems, $orderId, $totalPrice, $user) {
                foreach ($cartItems as $item) {
                    Rental::create([
                        'user_id' => $user->id,
                        'clothe_id' => $item->clothe_id,
                        'order_id' => $orderId,
                        'size' => $item->size,
                        'start_date' => $item->start_date,
                        'end_date' => $item->end_date,
                        'duration' => max(1, Carbon::parse($item->start_date)->diffInDays(Carbon::parse($item->end_date))),
                        'total_price' => $totalPrice,
                        'status_payment' => 'pending',
                        'status_barang' => 'waiting',
                        'user_address' => $user->address,
                        'user_lat' => $user->latitude,
                        'user_lng' => $user->longitude,
                        'current_lat' => -6.9764,
                        'current_lng' => 107.6327,
                    ]);
                }
                Cart::where('user_id', $user->id)->delete();
                return response()->json(['snap_token' => Snap::getSnapToken(['transaction_details' => ['order_id' => $orderId, 'gross_amount' => (int)$totalPrice]])]);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function payPenalty($id)
    {
        $rental = Rental::findOrFail($id);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $penaltyOrderId = 'PENALTY-' . $rental->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $penaltyOrderId,
                'gross_amount' => (int) $rental->penalty_fee,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id' => 'P1',
                    'price' => (int) $rental->penalty_fee,
                    'quantity' => 1,
                    'name' => 'Denda Keterlambatan: ' . $rental->clothe->character_name,
                ]
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        
        return response()->json(['snap_token' => $snapToken]);
    }

    // --- WEBHOOK MIDTRANS (Update Bayar & Kurangi Stok) ---
    public function notification(Request $request)
    {
        $notification = json_decode($request->getContent());
        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.server_key'));

        if ($notification->signature_key !== $validSignatureKey) return response()->json(['message' => 'Invalid signature'], 403);

        $transaction = $notification->transaction_status;
        $rentals = Rental::where('order_id', $notification->order_id)->get();

        if ($transaction == 'settlement' || $transaction == 'capture') {
            foreach ($rentals as $rental) {
                if ($rental->status_payment !== 'settlement') {
                    $rental->update(['status_payment' => 'settlement']);
                    $clothe = Clothe::find($rental->clothe_id);
                    $column = 'stok_' . strtolower($rental->size);
                    if ($clothe && Schema::hasColumn('clothes', $column)) $clothe->decrement($column);
                }
            }
        }
        return response()->json(['message' => 'OK']);
    }

    // --- UPDATE STATUS BARANG & DENDA OTOMATIS ---
    public function updateStatus(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);
        $status = $request->status_barang;

        if ($status === 'picked_up') {
            if ($rental->status_payment !== 'settlement') return back()->with('error', 'Belum lunas!');
            $rental->update(['status_barang' => 'picked_up']);
            return back()->with('success', 'Barang dikirim!');
        } 
        
        if ($status === 'returned') {
            $now = now()->startOfDay(); 
            $deadline = Carbon::parse($rental->end_date)->startOfDay();
            $penalty = 0;

            // Logika Denda Otomatis
            if ($now->gt($deadline)) {
                $daysLate = $now->diffInDays($deadline);
                $penalty = $daysLate * 50000; // Tarif 50rb per hari
            }

            // Simpan status dan nilai denda ke database
            $rental->update([
                'status_barang' => 'returned',
                'penalty_fee' => $penalty
            ]);
            
            // Tambah stok kembali
            $clothe = $rental->clothe;
            $column = 'stok_' . strtolower($rental->size);
            if ($clothe && Schema::hasColumn('clothes', $column)) $clothe->increment($column);
            
            return back()->with('success', 'Barang kembali. Denda: Rp ' . number_format($penalty));
        }

        return back();
    }
}