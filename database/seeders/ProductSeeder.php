<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Greate Taste',
            'available_stock' => 20,
        ]);
        
        Product::create([
            'name' => 'Kopiko',
            'available_stock' => 20,
        ]);
        
    }
}
