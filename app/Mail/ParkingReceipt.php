<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ParkingReceipt extends Mailable
{
    use SerializesModels;

    public function __construct(public Reservation $reservation) {}

    public function build()
    {
        return $this->subject('Smart Parking Receipt #' . $this->reservation->id)
                    ->view('emails.parking-receipt');
    }
}