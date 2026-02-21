<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParkingSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id', 'slot_number', 'type', 'status',
    ];

    public function location()
    {
        return $this->belongsTo(ParkingLocation::class, 'location_id');
    }
}