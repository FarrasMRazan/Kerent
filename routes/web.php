<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController, 
    RentalController, 
    ClotheController, 
    ProfileController, 
    CategoryController,
    AdminController,
    CartController
};

Route::get('/', function () {
    return view('welcome');
});

// Webhook Midtrans (Pusat Notifikasi Pembayaran)
// Harus di luar auth karena diakses otomatis oleh server Midtrans
Route::post('/midtrans-callback', [RentalController::class, 'notification']);

Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-rentals', [DashboardController::class, 'myRentals'])->name('user.rentals');

    // --- RENTAL & TRANSACTION ---
    Route::controller(RentalController::class)->group(function () {
        Route::post('/rentals/{id}/update-status', 'updateStatus')->name('rentals.updateStatus');
        Route::post('/checkout/process', 'checkout')->name('checkout.process');
        
        // PINDAHKAN KE SINI agar aman dan terlindungi auth
        Route::post('/rental/pay-penalty/{id}', 'payPenalty')->name('rental.pay-penalty');
    });

    // --- AREA KHUSUS ADMIN ---
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('clothes', ClotheController::class)->parameters(['clothes' => 'clothe'])->except(['show']);
        Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
        
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/settings/update', [AdminController::class, 'updateShop'])->name('admin.shop.update');
    });

    // --- KERANJANG ---
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart.index');
        Route::post('/cart', 'store')->name('cart.store');
        Route::post('/cart/add/{id}', 'add')->name('cart.add');
        Route::delete('/cart/{id}', 'destroy')->name('cart.destroy');
    });

    // --- PROFIL & SETTINGS ---
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::get('/clothes/{clothe}', [ClotheController::class, 'show'])->name('clothes.show');
});

require __DIR__ . '/auth.php';