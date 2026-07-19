<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin'),
            'role' => 'Admin',
            'contact' => '03451231237',
        ]);
        User::create([
            'name' => 'test',
            'email' => 'test@email.com',
            'password' => Hash::make('123'),
            'role' => 'Orderbooker',
            'contact' => '03451231238',
        ]);
    }
}
