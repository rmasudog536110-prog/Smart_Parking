<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ParkingLocation;

class IndexController extends Controller
{
    public function index()
    {
        $locations = ParkingLocation::where('is_available', true)
            ->limit(6)
            ->get();
        return view('home', compact('locations'));
    }
}
