<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParkingSlot;

class ParkingSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ParkingSlot::create([
            'location_id' => 1,
            'slot_number' => 1,
            'type' => 'compact',
            'status' => 'occupied',
        ]);

    }
}
