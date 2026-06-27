<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BookingController;

Route::redirect('/', '/dashboard');

// Auth routes
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login-store', [UserController::class, 'loginStore'])->name('login.store');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register-store', [UserController::class, 'registerStore'])->name('register.store');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Public Room Routes
Route::get('/rooms', [UserController::class, 'rooms'])->name('user.rooms');
Route::get('/room/{slug}', [UserController::class, 'roomDetails'])->name('user.room.details');

// Admin Routes
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

    // Property
    Route::get('/admin/property', [PropertyController::class, 'index'])->name('admin.property');
    Route::post('/admin/property/store', [PropertyController::class, 'store'])->name('admin.property.store');
    Route::post('/admin/property/update/{id}', [PropertyController::class, 'update'])->name('admin.property.update');
    Route::get('/admin/property/delete/{id}', [PropertyController::class, 'destroy'])->name('admin.property.delete');

    // Booking
    Route::get('/admin/bookings', [BookingController::class, 'bookings'])->name('admin.bookings');

    // Payment
    Route::get('/admin/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::get('/admin/payment/status/{id}', [AdminController::class, 'paymentStatus'])->name('admin.payment.status');
});

    Route::get('/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');

// User Routes
Route::middleware(['user'])->group(function () {
    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/profile/change-password', [UserController::class, 'updatePassword'])->name('user.password.update');

    // Booking
    Route::get('/booking-summary/{slug}', [UserController::class, 'bookingSummary'])->name('user.booking.summary');

    // Booking
    Route::post('/booking/store/{slug}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('user.bookings');
});
