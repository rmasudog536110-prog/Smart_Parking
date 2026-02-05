<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParkingLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'latitude', 'longitude',
        'capacity', 'hourly_rate', 'is_available'
    ];

    public function slots()
    {
        return $this->hasMany(ParkingSlot::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

