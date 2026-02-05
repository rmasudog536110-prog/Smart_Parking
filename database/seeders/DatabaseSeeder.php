<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@sample.test',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->call([
            ParkingLocationSeeder::class,
            ParkingSlotSeeder::class,
        ]);
    }
}
