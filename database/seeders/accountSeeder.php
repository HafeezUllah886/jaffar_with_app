<?php

namespace Database\Seeders;

use App\Models\accounts;
use Illuminate\Database\Seeder;

class accountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        accounts::create(
            [
                'title' => 'Cash Account',
                'type' => 'Business',
                'category' => 'Cash',
            ]
        );

        accounts::create(
            [
                'title' => 'Walk-In Customer',
                'type' => 'Customer',
                'long' => 67.00025654670316,
                'lat' => 30.179139145257444,
                'code' => 'HCO123434',
            ]
        );

        accounts::create(
            [
                'title' => 'Walk-In Vendor',
                'type' => 'Vendor',
            ]
        );
    }
}
