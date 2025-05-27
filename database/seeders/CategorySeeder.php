<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Ружья'],
            ['name' => 'Патроны'],
            ['name' => 'Оптика'],
            ['name' => 'Аксессуары'],
            ['name' => 'Камуфляж'],
            ['name' => 'Термобельё'],
            ['name' => 'Обувь'],
            ['name' => 'Защитная экипировка для охоты'],
            ['name' => 'Одежда'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 