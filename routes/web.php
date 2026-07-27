<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PharmaController;
use App\Http\Controllers\HospitalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- User Public Routes (UserController) ---
Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/products', [UserController::class, 'products'])->name('products.index');
Route::get('/doctors', [UserController::class, 'doctors'])->name('doctors.index');
Route::get('/hospitals', [UserController::class, 'hospitals'])->name('hospitals.index');
Route::get('/product/{id}', [UserController::class, 'showProduct'])->name('products.show');

// --- Auth Routes (UserController) ---
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/doctor/register', [UserController::class, 'showDoctorRegister'])->name('doctor.register');
Route::post('/doctor/register', [UserController::class, 'processDoctorRegister'])->name('doctor.register.submit');
Route::get('/hospital/register', [UserController::class, 'showHospitalRegister'])->name('hospital.register');
Route::post('/hospital/register', [UserController::class, 'processHospitalRegister'])->name('hospital.register.submit');
Route::get('/pharma/register', [UserController::class, 'showPharmaRegister'])->name('pharma.register');
Route::post('/pharma/register', [UserController::class, 'processPharmaRegister'])->name('pharma.register.submit');
Route::get('/register/verify-otp', [UserController::class, 'showVerifyOtp'])->name('register.verify_otp');
Route::post('/register/verify-otp', [UserController::class, 'verifyOtp']);
Route::post('/register/resend-otp', [UserController::class, 'resendOtp'])->name('register.resend_otp');

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

    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// --- Admin Routes (AdminController + DoctorController + PharmaController) ---
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminController::class, 'login']);
    });

    // Protected Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
        
        // Doctor Management by Admin
        Route::resource('doctors', DoctorController::class);
        Route::put('/doctors/{id}/toggle-active', [DoctorController::class, 'toggleActive'])->name('doctors.toggle_active');

        // Hospital Management by Admin
        Route::resource('hospitals', HospitalController::class);
        Route::put('/hospitals/{id}/toggle-active', [HospitalController::class, 'toggleActive'])->name('hospitals.toggle_active');

        // Pharma Management by Admin
        Route::resource('pharmas', PharmaController::class);

        // User Management by Admin
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

        // Category & Subcategory Management
        Route::get('/doctor-categories', [\App\Http\Controllers\Admin\CategoryController::class, 'doctorIndex'])->name('categories.doctor');
        Route::post('/doctor-categories', [\App\Http\Controllers\Admin\CategoryController::class, 'storeDoctorCategory'])->name('categories.doctor.store');
        Route::post('/doctor-subcategories', [\App\Http\Controllers\Admin\CategoryController::class, 'storeDoctorSubcategory'])->name('categories.doctor_subcategory.store');
        Route::delete('/doctor-categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroyDoctorCategory'])->name('categories.doctor.destroy');
        Route::delete('/doctor-subcategories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroyDoctorSubcategory'])->name('categories.doctor_subcategory.destroy');

        Route::get('/product-categories', [\App\Http\Controllers\Admin\CategoryController::class, 'productIndex'])->name('categories.product');
        Route::post('/product-categories', [\App\Http\Controllers\Admin\CategoryController::class, 'storeProductCategory'])->name('categories.product.store');
        Route::post('/product-subcategories', [\App\Http\Controllers\Admin\CategoryController::class, 'storeProductSubcategory'])->name('categories.product_subcategory.store');
        Route::delete('/product-categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroyProductCategory'])->name('categories.product.destroy');
        Route::delete('/product-subcategories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroyProductSubcategory'])->name('categories.product_subcategory.destroy');
        
        // Advertisements Management
        Route::get('/advertisements', [AdminController::class, 'advertisementsIndex'])->name('advertisements.index');
        Route::get('/advertisements/create', [AdminController::class, 'advertisementsCreate'])->name('advertisements.create');
        Route::post('/advertisements', [AdminController::class, 'advertisementsStore'])->name('advertisements.store');
        Route::get('/advertisements/{id}/edit', [AdminController::class, 'advertisementsEdit'])->name('advertisements.edit');
        Route::put('/advertisements/{id}', [AdminController::class, 'advertisementsUpdate'])->name('advertisements.update');
        Route::delete('/advertisements/{id}', [AdminController::class, 'advertisementsDestroy'])->name('advertisements.destroy');
        Route::post('/advertisements/set-popup/{id}', [AdminController::class, 'advertisementsSetPopup'])->name('advertisements.set_popup');
    });
});

// AJAX Routes (No prefix to keep URL clean, or inside admin if appropriate)
Route::get('/api/doctor-subcategories/{categoryId}', [\App\Http\Controllers\Admin\CategoryController::class, 'getDoctorSubcategories']);
Route::get('/api/product-subcategories/{categoryId}', [\App\Http\Controllers\Admin\CategoryController::class, 'getProductSubcategories']);

// --- Doctor Role Routes (DoctorController) ---
Route::prefix('doctor')->name('doctor.')->middleware('auth:doctor')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::post('/unavailability', [DoctorController::class, 'toggleAvailability'])->name('unavailability.toggle');
    Route::get('/profile', [DoctorController::class, 'profile'])->name('profile');
    Route::put('/profile', [DoctorController::class, 'updateProfile'])->name('profile.update');
    Route::put('/bookings/{id}/status', [DoctorController::class, 'updateBookingStatus'])->name('bookings.status.update');
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
    Route::put('/orders/{id}/status', [PharmaController::class, 'updateOrderStatus'])->name('orders.status.update');
    Route::get('/profile', [PharmaController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [PharmaController::class, 'updateProfile'])->name('profile.update');

    // Category Management for Pharma (reusing same logic)
    Route::get('/product-categories', [PharmaController::class, 'productCategories'])->name('categories.product');
    Route::post('/product-categories', [PharmaController::class, 'storeProductCategory'])->name('categories.product.store');
    Route::post('/product-subcategories', [PharmaController::class, 'storeProductSubcategory'])->name('categories.product_subcategory.store');
    Route::delete('/product-categories/{id}', [PharmaController::class, 'destroyProductCategory'])->name('categories.product.destroy');
    Route::delete('/product-subcategories/{id}', [PharmaController::class, 'destroyProductSubcategory'])->name('categories.product_subcategory.destroy');
});

// --- Hospital Role Routes (HospitalController) ---
Route::prefix('hospital')->name('hospital.')->middleware('auth:hospital')->group(function () {
    Route::get('/dashboard', [HospitalController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [HospitalController::class, 'profile'])->name('profile');
    Route::put('/profile', [HospitalController::class, 'updateProfile'])->name('profile.update');
    Route::get('/doctors/create', [HospitalController::class, 'doctorsCreate'])->name('doctors.create');
    Route::post('/doctors', [HospitalController::class, 'doctorsStore'])->name('doctors.store');
    Route::get('/doctors/{id}/edit', [HospitalController::class, 'doctorsEdit'])->name('doctors.edit');
    Route::put('/doctors/{id}', [HospitalController::class, 'doctorsUpdate'])->name('doctors.update');
    Route::delete('/doctors/{id}', [HospitalController::class, 'doctorsDestroy'])->name('doctors.destroy');
});
