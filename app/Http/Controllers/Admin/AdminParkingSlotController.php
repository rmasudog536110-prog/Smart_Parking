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
        // Eager load location to prevent N+1 query issues
        $slots = ParkingSlot::with('location')->latest()->get();
        return view('admin.parking-slots.index', compact('slots'));
    }

    public function create()
    {
        $locations = ParkingLocation::all();
        return view('admin.parking-slots.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_id'  => 'required|exists:parking_locations,id',
            'slot_number'  => 'required|string|unique:parking_slots,slot_number',
            'type'         => 'required|in:car,motorcycle,pwd',
            'status'       => 'required|in:available,occupied,maintenance,reserved',
        ]);

        ParkingSlot::create($validated);

        return redirect()->route('admin.parking-slots.index')
            ->with('success', 'Parking slot created successfully.');
    }

    public function edit(ParkingSlot $parkingSlot)
    {
        $locations = ParkingLocation::all();
        return view('admin.parking-slots.edit', compact('parkingSlot', 'locations'));
    }

    public function update(Request $request, ParkingSlot $parkingSlot)
    {
        $validated = $request->validate([
            'location_id' => 'required|exists:parking_locations,id',
            'slot_number' => 'required|string|unique:parking_slots,slot_number,' . $parkingSlot->id,
            'type'        => 'required|in:car,motorcycle,pwd',
            'status'      => 'required|in:available,occupied,maintenance,reserved',
        ]);

        $parkingSlot->update($validated);

        return redirect()->route('admin.parking-slots.index')
            ->with('success', 'Parking slot updated.');
    }

    public function destroy(ParkingSlot $parkingSlot)
    {
        $parkingSlot->delete();
        return back()->with('success', 'Slot removed.');
    }

    /**
     * IoT API Endpoint
     * This is a special function for your sensors to call
     */
    public function updateStatusViaSensor(Request $request, $id)
    {
        // Sensors usually send a simple API key for security
        if ($request->header('X-Sensor-Key') !== env('SENSOR_API_KEY')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $slot = ParkingSlot::findOrFail($id);
        $slot->update(['status' => $request->status]); // 'available' or 'occupied'

        return response()->json(['message' => 'Status updated']);
    }
}