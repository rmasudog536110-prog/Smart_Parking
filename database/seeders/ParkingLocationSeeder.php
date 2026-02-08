<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParkingLocation;

class ParkingLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    ParkingLocation::create([
        'name' => 'UM Matina - Library Parking',
        'address' => 'UM Matina Campus, Matina Pangi Rd, Davao City',
        'latitude' => 7.06520000,
        'longitude' => 125.59620000,
        'capacity' => 20, 
        'hourly_rate' => 20.00, 
        'is_available' => true,
    ]);

    }

}
