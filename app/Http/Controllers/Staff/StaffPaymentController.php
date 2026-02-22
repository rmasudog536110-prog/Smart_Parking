<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class StaffPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'slot', 'vehicle'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->paginate(15);

        return view('staff.payments', compact('reservations'));
    }

    public function markPaid(Reservation $reservation)
    {
        $reservation->update([
            'payment_status' => 'completed',
            'status'         => 'active',
        ]);

        return back()->with('success', "Reservation #{$reservation->id} marked as completed.");
    }

    public function refund(Reservation $reservation)
    {
        $reservation->update([
            'payment_status' => 'refunded',
            'status'         => 'cancelled',
        ]);

        return back()->with('success', "Reservation #{$reservation->id} has been refunded.");
    }
}