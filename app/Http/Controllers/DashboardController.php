<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Clothe;
use App\Models\Rental;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. LOGIC ADMIN
        if ($user->role === 'admin') {
            $recent_rentals = Rental::with(['user', 'clothe'])->latest()->paginate(10);
            return view('dashboard.admin', [
                'total_pendapatan' => Rental::where('status_payment', 'settlement')->sum('total_price'),
                'total_transaksi' => Rental::count(),
                'total_client' => Rental::distinct('user_id')->count('user_id'),
                'total_baju' => Clothe::count(),
                'recent_rentals' => $recent_rentals
            ]);
        }

        // 2. LOGIC STAFF
        if ($user->role === 'staff') {
            // Ambil data untuk box Ready to Pickup
            $pickups = Rental::with(['user', 'clothe'])
                             ->where('status_barang', 'waiting')
                             ->where('status_payment', 'settlement')
                             ->paginate(5, ['*'], 'pickups');

            // Ambil data untuk box Pending Returns
            $returns = Rental::with(['user', 'clothe'])
                             ->where('status_barang', 'picked_up')
                             ->paginate(5, ['*'], 'returns');

            // Ambil data untuk tabel manajemen stok (Clothes)
            $clothes = Clothe::with(['category', 'sizes'])->paginate(10, ['*'], 'clothes');

            return view('dashboard.staff', compact('pickups', 'returns', 'clothes'));
        }

        // 3. LOGIC CLIENT (Katalog)
        if ($user->role === 'client') {
            $categories = Category::all();
            $query = Clothe::with(['category']);
            
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }
            if ($request->filled('search')) {
                $query->where('character_name', 'like', '%' . $request->search . '%');
            }

            $all_clothes = $query->latest()->paginate(8);
            return view('dashboard.client', compact('all_clothes', 'categories'));
        }
        
        abort(403, 'User role tidak dikenali.');
    }

    // Riwayat penyewaan untuk Client
    public function myRentals()
    {
        $user = Auth::user();

        $rentals = Rental::with('clothe')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->each(function ($rental) {
                if ($rental->status_barang !== 'returned') {
                    $deadline = Carbon::parse($rental->end_date)->startOfDay();
                    $now = now()->startOfDay();

                    if ($now->gt($deadline)) {
                        $daysLate = $now->diffInDays($deadline);
                        $rental->penalty_fee = $daysLate * 50000;
                    } else {
                        $rental->penalty_fee = 0;
                    }
                } else {
                    $rental->penalty_fee = 0;
                }
            });

        return view('dashboard.my-rentals', compact('rentals'));
    }

}