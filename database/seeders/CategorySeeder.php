<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Kategori 1'],
            ['id' => 2, 'name' => 'Kategori 2'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 