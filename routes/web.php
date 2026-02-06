<?php

use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\User\ParkLocController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\User\VehicleController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\SubscriptionController;
use App\Http\Controllers\User\ContactsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminParkLocController;
use App\Http\Controllers\Admin\AdminParkSlotController;
use App\Http\Controllers\Admin\AdminReservationsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
Route::view('/', 'landing')->name('landing');

Route::get('/login', [RegisteredUserController::class, 'showLogin'])->name('login');
Route::post('/login', [RegisteredUserController::class, 'login'])->name('login.submit');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store');

    Route::get('/register', [RegisteredUserController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'register'])->name('register.submit');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register.store');

Route::view('/forgot-password', 'auth.forgot-password')
    ->name('password.request');
});

Route::get('/logout', [RegisteredUserController::class, 'logout'])->name('logout');
Route::post('/logout', [RegisteredUserController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

//Auth User
Route::middleware('auth')->group(function () {
    
    Route::get('/home', [IndexController::class, 'index'])->name('home');

    Route::get('/parking', [ParkLocController::class, 'index'])
        ->name('parking.index');

    Route::get('/parking/{parkingLocation}', [ParkLocController::class, 'show'])
        ->name('parking.show');

    Route::post('/contact', [ContactsController::class, 'store'])
        ->name('contact.store');
    // Vehicles
    Route::resource('vehicles', VehicleController::class)
        ->except(['show']);

    // Reservations
    Route::resource('reservations', ReservationController::class);

    Route::post('/reservations/{reservation}/start',
        [ReservationController::class, 'start'])
        ->name('reservations.start');

    Route::post('/reservations/{reservation}/end',
        [ReservationController::class, 'end'])
        ->name('reservations.end');

    // Payments
    Route::post('/payments/{reservation}',
        [PaymentController::class, 'store'])
        ->name('payments.store');

    // Subscriptions
    Route::get('/subscription',
        [SubscriptionController::class, 'index'])
        ->name('subscription.index');

    Route::post('/subscription/subscribe',
        [SubscriptionController::class, 'subscribe'])
        ->name('subscription.subscribe');

    Route::post('/subscription/cancel',
        [SubscriptionController::class, 'cancel'])
        ->name('subscription.cancel');
});

//Admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard',
            [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Parking Locations
        Route::resource('parking-locations',
            AdminParkLocController::class);

        // Parking Slots
        Route::resource('parking-slots',
            AdminParkingSlotController::class);

        // Reservations
        Route::resource('reservations',
            AdminReservationController::class)
            ->only(['index', 'show', 'destroy']);

        // Users
        Route::resource('users',
            AdminUserController::class)
            ->only(['index', 'show', 'update', 'destroy']);
});

