<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingLocation;
use Illuminate\Http\Request;

class AdminParkLocController extends Controller
{
    public function index()
    {
        return view('admin.parking-locations.index', [
            'locations' => ParkingLocation::all()
        ]);
    }

    public function store(Request $request)
    {
        ParkingLocation::create($request->all());
        return back();
    }

    public function destroy(ParkingLocation $parkingLocation)
    {
        $parkingLocation->delete();
        return back();
    }
}
