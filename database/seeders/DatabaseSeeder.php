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
            'password' => bcrypt(value: 'password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john@sample.test',
            'password' => bcrypt('john123'),
            'role' => 'user',
        ]);

        $this->call([
            ParkingLocationSeeder::class,
            ParkingSlotSeeder::class,
        ]);
    }
}
