<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UnifiedAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Pharma\PharmaDashboardController;
use App\Http\Controllers\UserAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products', [App\Http\Controllers\HomeController::class, 'products'])->name('products.index');
Route::get('/doctors', [App\Http\Controllers\HomeController::class, 'doctors'])->name('doctors.index');
Route::get('/product/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('products.show');

// Unified Authentication Routes
Route::get('/login', [UnifiedAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UnifiedAuthController::class, 'login']);
Route::post('/logout', [UnifiedAuthController::class, 'logout'])->name('logout');

// User Registration
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [UserAuthController::class, 'register']);

// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');

    // Order Routes
    Route::post('/orders', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');

    // Doctor Booking Routes
    Route::get('/doctors/{id}/book', [App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-appointments', [App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Doctor Management
    Route::resource('doctors', App\Http\Controllers\DoctorController::class);

    // Pharma Management
    Route::resource('pharmas', App\Http\Controllers\PharmaController::class);
});

// Doctor Routes
Route::prefix('doctor')->name('doctor.')->middleware('auth:doctor')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
});

// Pharma Routes
Route::prefix('pharma')->name('pharma.')->middleware('auth:pharma')->group(function () {
    Route::get('/dashboard', [PharmaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/products/create', [PharmaDashboardController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [PharmaDashboardController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [PharmaDashboardController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [PharmaDashboardController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [PharmaDashboardController::class, 'destroyProduct'])->name('products.destroy');
    Route::get('/orders/{id}', [PharmaDashboardController::class, 'showOrder'])->name('orders.show');
});
