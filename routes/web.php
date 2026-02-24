<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PharmaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- User Public Routes (UserController) ---
Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/products', [UserController::class, 'products'])->name('products.index');
Route::get('/doctors', [UserController::class, 'doctors'])->name('doctors.index');
Route::get('/product/{id}', [UserController::class, 'showProduct'])->name('products.show');

// --- Auth Routes (UserController) ---
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register']);

// --- Protected User Routes (UserController) ---
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [UserController::class, 'cartIndex'])->name('cart.index');
    Route::post('/cart/add/{id}', [UserController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{id}', [UserController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [UserController::class, 'removeFromCart'])->name('cart.remove');

    // Orders
    Route::post('/orders', [UserController::class, 'storeOrder'])->name('orders.store');
    Route::get('/orders', [UserController::class, 'ordersIndex'])->name('orders.index');
    Route::get('/orders/{id}', [UserController::class, 'showOrder'])->name('orders.show');

    // Doctor Bookings
    Route::get('/doctors/{id}/book', [UserController::class, 'createBooking'])->name('bookings.create');
    Route::post('/bookings', [UserController::class, 'storeBooking'])->name('bookings.store');
    Route::get('/my-appointments', [UserController::class, 'myBookings'])->name('bookings.my');
});

// --- Admin Routes (AdminController + DoctorController + PharmaController) ---
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Doctor Management by Admin
    Route::resource('doctors', DoctorController::class);

    // Pharma Management by Admin
    Route::resource('pharmas', PharmaController::class);
});

// --- Doctor Role Routes (DoctorController) ---
Route::prefix('doctor')->name('doctor.')->middleware('auth:doctor')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
});

// --- Pharma Role Routes (PharmaController) ---
Route::prefix('pharma')->name('pharma.')->middleware('auth:pharma')->group(function () {
    Route::get('/dashboard', [PharmaController::class, 'dashboard'])->name('dashboard');
    Route::get('/products/create', [PharmaController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [PharmaController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [PharmaController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [PharmaController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [PharmaController::class, 'destroyProduct'])->name('products.destroy');
    Route::get('/orders/{id}', [PharmaController::class, 'showOrder'])->name('orders.show');
});
