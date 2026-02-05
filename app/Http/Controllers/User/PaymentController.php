<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Reservation $reservation)
    {
        Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Payment successful');
    }
}
