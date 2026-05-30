<?php

namespace Database\Seeders;

use App\Models\deliveryman;
use App\Models\transporter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class deliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        transporter::create(
            [
                'name' => 'Test Transporter',
            ]
        );

        deliveryman::create(
            [
                'name' => 'Test Delivery Man',
            ]
        );
    }
}
