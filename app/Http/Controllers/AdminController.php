<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function settings()
    {
        $user = Auth::user();
        return view('admin.settings', compact('user'));
    }

    public function updateShop(Request $request)
    {
        // Validasi input
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'required|string',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'shop_name' => $request->shop_name,
            'shop_address' => $request->shop_address,
        ]);

        return redirect()->back()->with('success', 'Identitas toko berhasil diperbarui!');
    }
}
