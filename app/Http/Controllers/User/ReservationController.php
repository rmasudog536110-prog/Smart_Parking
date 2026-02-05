<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = auth()->user()->reservations()->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        $reservation = Reservation::create($request->all());
        ParkingSlot::where('id', $request->parking_slot_id)
            ->update(['status' => 'reserved']);

        return redirect()->route('reservations.index');
    }

    public function start(Reservation $reservation)
    {
        $reservation->update(['status' => 'active']);
        return back();
    }

    public function end(Reservation $reservation)
    {
        $reservation->update(['status' => 'completed']);
        $reservation->slot->update(['status' => 'available']);
        return back();
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);

        $reservation->update(['status' => 'cancelled']);

        return back();
    }

}
