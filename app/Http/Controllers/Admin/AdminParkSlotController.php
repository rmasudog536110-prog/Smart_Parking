<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use App\Models\ParkingLocation;
use Illuminate\Http\Request;

class AdminParkingSlotController extends Controller
{
    public function index()
    {
        $slots = ParkingSlot::with('location')->get();
        return view('admin.parking-slots.index', compact('slots'));
    }

    public function create()
    {
        $locations = ParkingLocation::all();
        return view('admin.parking-slots.create', compact('locations'));
    }

    public function store(Request $request)
    {
        ParkingSlot::create($request->all());
        return redirect()->route('admin.parking-slots.index');
    }

    public function edit(ParkingSlot $parkingSlot)
    {
        $locations = ParkingLocation::all();
        return view('admin.parking-slots.edit', compact('parkingSlot', 'locations'));
    }

    public function update(Request $request, ParkingSlot $parkingSlot)
    {
        $parkingSlot->update($request->all());
        return redirect()->route('admin.parking-slots.index');
    }

    public function destroy(ParkingSlot $parkingSlot)
    {
        $parkingSlot->delete();
        return back();
    }
}
