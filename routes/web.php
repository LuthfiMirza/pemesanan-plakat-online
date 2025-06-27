<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlakatController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

// Public routes
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
Route::get('/plakats', [PlakatController::class, 'index']);
Route::get('/product', [ProductController::class, 'index']);

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Payment routes
Route::get('/pembayaran/{plakat_id}', [PaymentController::class, 'showPaymentForm'])->name('pembayaran');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/upload/{transaction_id}', [PaymentController::class, 'showUploadForm'])->name('payment.upload');
Route::post('/payment/upload/{transaction_id}', [PaymentController::class, 'uploadProof'])->name('payment.upload.post');
Route::get('/payment/success/{transaction_id}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/api/payment/status/{transaction_id}', [PaymentController::class, 'getPaymentStatus'])->name('payment.status.api');

// Legacy payment routes (for backward compatibility)
Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

// User dashboard routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');
    Route::get('/order-history', [DashboardController::class, 'orderHistory'])->name('order.history');
    Route::get('/invoice/{id}', [DashboardController::class, 'showInvoice'])->name('invoice.show');
});

// Admin routes (requires authentication and admin role)
Route::middleware(['auth', 'admin'])->prefix('admin-panel')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/sales-report', [AdminController::class, 'salesReport'])->name('admin.sales.report');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::patch('/transactions/{id}/status', [AdminController::class, 'updateTransactionStatus'])->name('admin.transactions.status');
});

