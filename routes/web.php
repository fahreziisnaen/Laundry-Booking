<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingCheckController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingStatusController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/check-booking', [BookingCheckController::class, 'index'])->name('bookings.check');
Route::post('/check-booking', [BookingCheckController::class, 'check'])->name('bookings.check.submit');

// Protected routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('bookings', BookingController::class);
    Route::get('/bookings/{booking:booking_code}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/users/create-admin', [UserController::class, 'createAdmin'])->name('users.create-admin');
    Route::resource('users', UserController::class)->middleware('can:viewAny,App\Models\User');
    Route::patch('/bookings/{booking}/status', [BookingStatusController::class, 'update'])
        ->name('bookings.status.update');
});
