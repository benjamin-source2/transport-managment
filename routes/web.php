<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingReportController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\TripReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Registration
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('buses', BusController::class);
        Route::resource('routes', RouteController::class);
        Route::resource('trips', TripController::class);
        Route::resource('bookings', BookingController::class);

        Route::get('reports/trips', [TripReportController::class, 'index'])->name('reports.trips');
        Route::get('reports/bookings', [BookingReportController::class, 'index'])->name('reports.bookings');
    });

    // Client routes
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
        Route::get('trips', [ClientController::class, 'trips'])->name('trips');
        Route::get('trips/{trip}/book', [ClientController::class, 'bookForm'])->name('trips.book');
        Route::post('trips/{trip}/book', [ClientController::class, 'book']);
        Route::get('bookings', [ClientController::class, 'myBookings'])->name('bookings');
        Route::delete('bookings/{booking}', [ClientController::class, 'cancelBooking'])->name('bookings.cancel');
    });

    // Profile routes
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo');
});

// Admin direct routes (backward compatibility - redirects)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.redirect');
    Route::get('buses', [BusController::class, 'index'])->name('buses.redirect');
    Route::get('routes', [RouteController::class, 'index'])->name('routes.redirect');
    Route::get('trips', [TripController::class, 'index'])->name('trips.redirect');
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.redirect');
    Route::get('reports/trips', [TripReportController::class, 'index'])->name('reports.trips.redirect');
    Route::get('reports/bookings', [BookingReportController::class, 'index'])->name('reports.bookings.redirect');
});
