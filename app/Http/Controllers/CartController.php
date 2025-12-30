<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Clothe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index()
{
    $cartItems = Cart::with(['clothe.category'])
        ->where('user_id', Auth::id())
        ->get();

    // Hitung total dengan perkalian hari
    $totalPrice = $cartItems->sum(function($item) {
        $start = \Carbon\Carbon::parse($item->start_date);
        $end = \Carbon\Carbon::parse($item->end_date);
        $days = $start->diffInDays($end);
        $days = $days <= 0 ? 1 : $days;

        return $item->clothe->price_per_day * $days;
    });

    return view('cart.index', compact('cartItems', 'totalPrice'));
}

    public function store(Request $request)
    {
        $request->validate([
            'clothe_id' => 'required|exists:clothes,id',
            'size' => 'required|in:S,M,L,XL',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Opsional: Cek apakah item yang sama (id, size, dan tanggal) sudah ada
        $exists = Cart::where('user_id', Auth::id())
            ->where('clothe_id', $request->clothe_id)
            ->where('size', $request->size)
            ->where('start_date', $request->start_date)
            ->first();

        if ($exists) {
            return redirect()->route('cart.index')->with('info', 'Kostum ini sudah ada di keranjang untuk jadwal tersebut.');
        }

        Cart::create([
            'user_id' => Auth::id(),
            'clothe_id' => $request->clothe_id,
            'size' => $request->size,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('cart.index')->with('success', 'Kostum berhasil ditambahkan ke keranjang!');
    }

    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}