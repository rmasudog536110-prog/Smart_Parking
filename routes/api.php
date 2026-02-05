<?php

use App\Http\Controllers\Api\{
    ParkingLocationController as ApiParkingLocationController,
    ParkingSlotController as ApiParkingSlotController,
    ReservationController as ApiReservationController
};

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/parking-locations',
        [ApiParkingLocationController::class, 'index']);

    Route::get('/parking-locations/{id}/slots',
        [ApiParkingSlotController::class, 'index']);

    Route::post('/reservations',
        [ApiReservationController::class, 'store']);
});
