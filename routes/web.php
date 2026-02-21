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
use App\Http\Controllers\Admin\AdminParkingSlotController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff\StaffDashboardController;

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
Route::view('/', 'landing')->name('landing');

Route::get('/login', [RegisteredUserController::class, 'showLogin'])->name('login');
Route::post('/login', [RegisteredUserController::class, 'login'])->name('login.submit');

Route::get('/register', [RegisteredUserController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'register'])->name('register.submit');


Route::view('/forgot-password', 'auth.forgot-password')
    ->name('password.request');
});

Route::view('/privacy', 'legalsht.privacy')->name('privacy');
Route::view('/terms', 'legalsht.terms')->name('terms');

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
    Route::resource('vehicles', VehicleController::class)->only(['index', 'store', 'destroy']);

    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])
        ->name('reservations.index');

    Route::get('/reservations/create/{parkingLocation}', [ReservationController::class, 'create'])
        ->name('reservations.create');

    Route::post('/reservations', [ReservationController::class, 'store'])
        ->name('reservations.store');

    Route::post('/reservations/{reservation}/start', [ReservationController::class, 'start'])
        ->name('reservations.start');

    Route::post('/reservations/{reservation}/end', [ReservationController::class, 'end'])
        ->name('reservations.end');

    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])
        ->name('reservations.destroy');
        
    Route::get('payment/{plan}', [PaymentController::class, 'paymentForm'])
        ->name('payment.form');

    Route::post('payment', [PaymentController::class, 'store'])
        ->name('payment.store');

    // Subscriptions
    Route::get('/subscription',
        [SubscriptionController::class, 'index'])
        ->name('subscription.index');

    Route::post('/subscription/show',
        [SubscriptionController::class, 'show'])
        ->name('subscription.show');

    Route::post('/subscription/cancel',
        [SubscriptionController::class, 'cancel'])
        ->name('subscription.cancel');

    //Proflile
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::post('/scan', [StaffDashboardController::class, 'scan'])->name('scan');
        Route::post('/reservations/{reservation}/status', [StaffDashboardController::class, 'updateStatus'])->name('reservations.status');
    });
});

//Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard',
            [AdminDashboardController::class, 'index'])
            ->name('dashboard');

       Route::get('/charts',
            [AdminDashboardController::class, 'charts'])
            ->name('charts');
        
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
        
        Route::get('/admin/reservations/scan/{id}/{token}', [AdminReservationController::class, 'scan'])
        ->name('admin.reservations.scan');

        // Users
        Route::resource('users',
            AdminUserController::class)
            ->only(['index', 'show', 'update', 'destroy']);
});

