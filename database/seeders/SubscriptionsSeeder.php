<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscription_plans')->insertOrIgnore([

            [
                'name' => 'Free Plan',
                'description' => 'Ideal for casual drivers who need occasional parking access.',
                'price' => 0.00,
                'duration' => 30,
                'features' => json_encode([
                    'Access to standard parking slots',
                    'Basic reservation system',
                    'Limited booking hours',
                ]),
                'is_active' => true,
                'free_trial' => true,
                'duration_days' => 30,
            ],

            [
                'name' => 'Basic Plan',
                'description' => 'Perfect for regular drivers who want priority booking and extended access.',
                'price' => 199.00,
                'duration' => 30,
                'features' => json_encode([
                    'Everything in Free Plan',
                    'Priority booking access',
                    'Extended reservation time',
                    'Access to better parking zones',
                ]),
                'is_active' => true,
                'free_trial' => false,
                'duration_days' => null,
            ],

            [
                'name' => 'Premium Plan',
                'description' => 'Best for frequent users who want VIP parking benefits and premium support.',
                'price' => 399.00,
                'duration' => 30,
                'features' => json_encode([
                    'Everything in Basic Plan',
                    'Reserved VIP parking slots',
                    'Guaranteed slot availability',
                    'Dedicated customer support',
                    'Early access to peak-hour booking',
                ]),
                'is_active' => true,
                'free_trial' => false,
                'duration_days' => null,
            ],

        ]);
    }
}