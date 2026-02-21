<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParkingLocation extends Model
{
    use HasFactory;

    protected $table = 'parking_locations';

    protected $fillable = [
        'name', 'address', 'latitude', 'longitude', 'hourly_rate', 'capacity',
    ];

    public function slots()
    {
        return $this->hasMany(ParkingSlot::class, 'location_id');
    }
}