<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(base_path('example-data/products.json'));
        $products = json_decode($json, true);

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 