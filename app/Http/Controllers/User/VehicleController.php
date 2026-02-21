<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = auth()->user()->vehicles;
        return view('vehicles.index', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_num' => 'required|string|max:20|unique:vehicle,plate_num',
            'brand'     => 'nullable|string|max:50',
            'model'     => 'nullable|string|max:50',
            'color'     => 'nullable|string|max:30',
        ]);

        auth()->user()->vehicles()->create($request->only('plate_num', 'brand', 'model', 'color'));

        return back()->with('success', 'Vehicle added successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);
        $vehicle->delete();
        return back()->with('success', 'Vehicle removed.');
    }
}