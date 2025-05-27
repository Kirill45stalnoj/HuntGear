<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $categories = DB::table('categories')->pluck('id', 'name');

        $products = [
            [
                'name' => 'Ружье Benelli Super Black Eagle 3',
                'description' => 'Самозарядное ружье 12 калибра',
                'price' => 120000.00,
                'image_url' => 'https://www.mil-dot.ru/upload/iblock/008/0087e4f7f64e1df308053f744474e142.jpeg',
                'category_id' => $categories['Ружья'],
            ],
            [
                'name' => 'Патроны 12/70',
                'description' => 'Патроны для гладкоствольного оружия',
                'price' => 100.00,
                'image_url' => 'https://www.mil-dot.ru/upload/iblock/008/0087e4f7f64e1df308053f744474e142.jpeg',
                'category_id' => $categories['Патроны'],
            ],
            [
                'name' => 'Бинокль Leupold BX-4',
                'description' => 'Бинокль 10x42 с просветленной оптикой',
                'price' => 45000.00,
                'image_url' => 'https://www.mil-dot.ru/upload/iblock/008/0087e4f7f64e1df308053f744474e142.jpeg',
                'category_id' => $categories['Оптика'],
            ],
            [
                'name' => 'Рюкзак охотничий',
                'description' => 'Вместительный рюкзак для охоты',
                'price' => 8000.00,
                'image_url' => 'https://www.mil-dot.ru/upload/iblock/008/0087e4f7f64e1df308053f744474e142.jpeg',
                'category_id' => $categories['Аксессуары'],
            ],
            [
                'name' => 'Костюм камуфляжный',
                'description' => 'Камуфляжный костюм для охоты',
                'price' => 15000.00,
                'image_url' => 'https://www.mil-dot.ru/upload/iblock/008/0087e4f7f64e1df308053f744474e142.jpeg',
                'category_id' => $categories['Камуфляж'],
            ],
            [
                'name' => 'Термобелье комплект',
                'description' => 'Комплект термобелья для холодной погоды',
                'price' => 5000.00,
                'image_url' => 'https://www.mil-dot.ru/upload/iblock/008/0087e4f7f64e1df308053f744474e142.jpeg',
                'category_id' => $categories['Термобельё'],
            ],
            [
                'name' => 'Сапоги охотничьи',
                'description' => 'Высокие сапоги из ЭВА для охоты',
                'price' => 12000.00,
                'image_url' => 'https://www.mil-dot.ru/upload/iblock/008/0087e4f7f64e1df308053f744474e142.jpeg',
                'category_id' => $categories['Обувь'],
            ],
            [
                'name' => 'Защитные очки',
                'description' => 'Защитные очки для стрельбы',
                'price' => 3000.00,
                'image_url' => 'https://www.mil-dot.ru/upload/iblock/008/0087e4f7f64e1df308053f744474e142.jpeg',
                'category_id' => $categories['Защитная экипировка для охоты'],
            ],
        ];

        DB::table('products')->insert($products);
    }
} 