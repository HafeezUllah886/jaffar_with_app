<?php

namespace Database\Seeders;

use App\Models\products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => "H100284", 'name' => "Chocolate Chip BP A01 (700ML)", "unitID" => 1, "volume" => 700, "pprice" => 416 , "wsprice" => 483, "price" => 575, 'tp' => 483, 'discount' => 0, 'catID' => 1],
            ['code' => "H100285", 'name' => "Kulfa BP A01 (700ML)", "unitID" => 1, "volume" => 700, "pprice" => 431 , "wsprice" => 500, "price" => 595, 'tp' => 500, 'discount' => 0, 'catID' => 1],
            ['code' => "H100286", 'name' => "Cookies & Cream BP A01 (700ML)", "unitID" => 1, "volume" => 700, "pprice" => 416 , "wsprice" => 583, "price" => 575, 'tp' => 583, 'discount' => 0, 'catID' => 1],
            ['code' => "H100195", 'name' => "Chocolate Chip FP A01", "unitID" => 1, "volume" => 1500, "pprice" => 771 , "wsprice" => 895, "price" => 1065, 'tp' => 895, 'discount' => 0, 'catID' => 2],
        ];
        products::insert($data);
    }
}
