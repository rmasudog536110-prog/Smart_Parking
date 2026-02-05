<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Vehicles;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'vehicle_id', 'slot_id',
        'start_time', 'end_time', 'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicles::class, 'vehicle_id');
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
