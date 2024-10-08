<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gym;

class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gym::create([
            'name' => 'F45 Training Campbelltown',
            'address' => 'Macarthur Square Shopping Centre, Kellicar Rd, Bolger St',
            'city' => 'Campbelltown',
            'state' => 'NSW',
            'postal_code' => '2560',
            'phone' => '0499 077 277',
            'stripe_account_id' => 'acct_1Q5aCCGheFmfjSxy',
        ]);

    }
}
