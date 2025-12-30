<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Clothe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class StaffController extends Controller
{
    public function index()
    {
        // Mengambil data untuk kolom Ready to Pickup
        $pickups = Rental::with(['user', 'clothe'])
            ->where('status_barang', 'waiting')
            ->whereIn('status_payment', ['pending', 'settlement'])
            ->orderByRaw("FIELD(status_payment, 'settlement', 'pending')")
            ->get();

        // Mengambil data untuk kolom Pending Returns
        $returns = Rental::with(['user', 'clothe'])
            ->where('status_barang', 'picked_up')
            ->get();

        // PENTING: Arahkan ke folder dashboard file staff
        return view('dashboard.staff', compact('pickups', 'returns'));
    }

    public function updateStatus(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);
        $status = $request->status_barang;

        if ($status === 'picked_up') {
            if ($rental->status_payment !== 'settlement') {
                return back()->with('error', 'Gagal! Pembayaran belum lunas.');
            }
            $rental->update(['status_barang' => 'picked_up']);
            $message = 'Baju berhasil diambil!';
        } 
        
        elseif ($status === 'returned') {
            $rental->update(['status_barang' => 'returned']);
            
            $clothe = $rental->clothe;
            if ($clothe) {
                $column = 'stok_' . strtolower($rental->size);
                if (Schema::hasColumn('clothes', $column)) {
                    $clothe->increment($column);
                }
            }
            $message = 'Baju kembali, stok bertambah!';
        }

        return back()->with('success', $message);
    }
}