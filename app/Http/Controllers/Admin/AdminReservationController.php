<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'vehicle', 'slot.location'])
            ->latest()
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        return view('reservations.show', compact('reservation'));
    }

    public function scan($id, $token)
    {
        $expected = hash_hmac('sha256', $id, config('app.key'));

        if (!hash_equals($expected, $token)) {
            abort(403, 'Invalid QR code.');
        }

        $reservation = Reservation::findOrFail($id);
        return view('admin.reservations.scan', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('reservations.index');
    }

}
