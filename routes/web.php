<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Payment routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout/{template}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/payment/create-invoice', [PaymentController::class, 'createInvoice'])->name('payment.create-invoice');
    Route::get('/payment/{payment}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/{payment}/failed', [PaymentController::class, 'failed'])->name('payment.failed');
    Route::get('/payment/{payment}/status', [PaymentController::class, 'status'])->name('payment.status');
});

// Public payment routes (for callbacks)
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/return', [PaymentController::class, 'return'])->name('payment.return');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/portal.php';
