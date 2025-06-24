<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlakatController;
use App\Http\Controllers\ProductController;

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/plakats', [PlakatController::class, 'index']);
Route::get('/product', [ProductController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('tentang');
});

Route::get('/contact', function () {
    return view('kontak');
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


Route::get('/pembayaran/{plakat_id}', function ($plakat_id) {
    $plakat = \App\Models\Plakat::findOrFail($plakat_id);
    return view('pembayaran', [
        'plakat_id' => $plakat_id,
        'plakat' => $plakat
    ]);
})->name('pembayaran');

Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');

