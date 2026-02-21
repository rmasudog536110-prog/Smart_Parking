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
            'password' => bcrypt(value: 'admin123'),
            'phone_number' => '1234567890',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john@sample.test',
            'password' => bcrypt('john123'),
            'phone_number' => '0987654321',
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Staff staff',
            'email' => 'staff@sample.test',
            'password' => bcrypt('staff123'),
            'phone_number' => '1122334455',
            'role' => 'staff',
        ]);

        $this->call(class: [
            ParkingLocationSeeder::class,
            ParkingSlotSeeder::class,
            SubscriptionsSeeder::class,
        ]);
    }
}
