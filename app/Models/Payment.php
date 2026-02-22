<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id','paymongo_reference','amount', 'payment_method', 'payment_status'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
