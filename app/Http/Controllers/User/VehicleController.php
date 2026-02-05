<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vehicles;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = auth()->user()->vehicles;
        return view('vehicles.index', compact('vehicles'));
    }

    public function store(StoreVehicleRequest  $request)
    {
        auth()->user()->vehicles()->create($request->validated());
        return back();
    }

    public function destroy(Vehicles $vehicle)
    {
        $vehicle->delete();
        return redirect()->back();
    }
}


