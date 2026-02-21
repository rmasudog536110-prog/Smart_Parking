<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\ParkingSlot;
use App\Models\Payment;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'vehicle_id', 'slot_id',
        'start_time', 'end_time', 'status',
        'is_free', 'total_amount', 'free_hours', 'paid_hours',
    ];

    protected $casts = [
        'start_time'   => 'datetime',
        'end_time'     => 'datetime',
        'is_free'      => 'boolean',
        'total_amount' => 'decimal:2',
        'free_hours'   => 'decimal:2',
        'paid_hours'   => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function slot()
    {
        return $this->belongsTo(ParkingSlot::class, 'slot_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}