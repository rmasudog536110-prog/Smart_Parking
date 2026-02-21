<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ParkingLocation;

class ParkLocController extends Controller
{
    public function index()
    {
        $locations = ParkingLocation::where('is_available', true)->get();
        return view('parking.index', compact('locations'));
    }

    public function show(ParkingLocation $parkingLocation)
    {
        $parkingLocation->load('slots');
        return view('parking.show', compact('parkingLocation'));
    }
}