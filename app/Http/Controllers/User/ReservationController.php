<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ParkingLocation;
use App\Models\Reservation;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private function hasActiveSubscription(): bool
    {
        $subscription = auth()->user()->subscription;
        return $subscription
            && $subscription->status === 'active'
            && $subscription->ends_at->isFuture();
    }

    public function index()
    {
        $reservations = auth()->user()->reservations()->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create($parkingLocation)
    {
        if (!$this->hasActiveSubscription()) {
            return redirect()->route('subscription.index')
                ->with('error', 'You need an active subscription to make a reservation.');
        }

        $hasActiveReservation = auth()->user()->reservations()
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($hasActiveReservation) {
            return redirect()->route('reservations.index')
                ->with('error', 'You already have an active reservation. Please complete or cancel it before making a new one.');
        }

        $parkingLocation = ParkingLocation::findOrFail($parkingLocation);
        $slots = $parkingLocation->slots()->where('status', 'available')->get();
        $vehicles = auth()->user()->vehicles()->get();
        $subscription = auth()->user()->subscription;

        return view('reservations.create', compact('parkingLocation', 'slots', 'vehicles', 'subscription'));
    }

    public function store(Request $request)
    {
        if (!$this->hasActiveSubscription()) {
            return redirect()->route('subscription.index')
                ->with('error', 'You need an active subscription to make a reservation.');
        }

        $hasActiveReservation = auth()->user()->reservations()
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($hasActiveReservation) {
            return redirect()->route('reservations.index')
                ->with('error', 'You already have an active reservation. Please complete or cancel it before making a new one.');
        }

        $request->validate([
            'slot_id'    => 'required|exists:parking_slots,id',
            'vehicle_id' => 'required|exists:vehicle,id',
            'start_time' => 'required|date|after:now',
            'end_time'   => 'required|date|after:start_time',
        ]);

        $subscription = auth()->user()->subscription;
        $startTime = \Carbon\Carbon::parse($request->start_time);
        $endTime = \Carbon\Carbon::parse($request->end_time);
        $requestedHours = $startTime->diffInHours($endTime);

        $freeHoursLeft = $subscription->freeHoursLeft();
        $freeHours = min($requestedHours, $freeHoursLeft);
        $paidHours = max(0, $requestedHours - $freeHours);

        $parkingSlot = ParkingSlot::findOrFail($request->slot_id);
        $hourlyRate = max(20, $parkingSlot->location->hourly_rate);
        $totalAmount = $paidHours * $hourlyRate;

        Reservation::create([
            'user_id'      => auth()->id(),
            'vehicle_id'   => $request->vehicle_id,
            'slot_id'      => $request->slot_id,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'status'       => 'pending',
            'is_free'      => $paidHours == 0,
            'total_amount' => $totalAmount,
            'free_hours'   => $freeHours,
            'paid_hours'   => $paidHours,
        ]);

        $parkingSlot->update(['status' => 'reserved']);

        if ($totalAmount == 0) {
            return redirect()->route('reservations.index')
                ->with('success', 'Reservation confirmed! Your free hours cover the full duration.');
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation created. Please proceed to payment.');
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
        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized.');
        }

        $reservation->update(['status' => 'cancelled']);
        $reservation->slot->update(['status' => 'available']);
        return back()->with('success', 'Reservation cancelled.');
    }
}