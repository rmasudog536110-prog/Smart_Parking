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
            'name' => 'Downtown Parking',
            'address' => 'Main Street',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'capacity' => 50,
            'hourly_rate' => 3.50,
            'is_available' => true,
        ]);

    }
}
