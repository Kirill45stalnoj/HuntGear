<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $products = [
            [
                'name' => 'Куртка охотничья',
                'description' => 'Теплая куртка для охоты с камуфляжным рисунком',
                'price' => 12999.99,
                'image_url' => 'https://www.mil-dot.ru/upload/iblock/008/0087e4f7f64e1df308053f744474e142.jpeg',
                'category_id' => $categories['Одежда'],
            ],
            [
                'name' => 'Сапоги охотничьи',
                'description' => 'Водонепроницаемые сапоги для охоты',
                'price' => 8999.99,
                'image_url' => 'https://avatars.mds.yandex.net/i?id=c0457b6d6f9bb07f474f80c5f214e788731284cc-8803246-images-thumbs&n=13',
                'category_id' => $categories['Обувь'],
            ],
            [
                'name' => 'Рюкзак охотничий',
                'description' => 'Вместительный рюкзак для охоты',
                'price' => 4999.99,
                'image_url' => 'https://avatars.mds.yandex.net/i?id=1d1dd122c88d3fd70035021e751555f0ffa38f66-12714748-images-thumbs&n=13',
                'category_id' => $categories['Аксессуары'],
            ],
            [
                'name' => 'Бинокль',
                'description' => 'Профессиональный бинокль для охоты',
                'price' => 15999.99,
                'image_url' => 'https://cdn1.ozone.ru/s3/multimedia-1-z/6954040115.jpg',
                'category_id' => $categories['Оптика'],
            ],
            [
                'name' => 'Охотничий нож',
                'description' => 'Качественный охотничий нож',
                'price' => 2999.99,
                'image_url' => 'https://www.eknives.de/images/produkte/i14/146086.jpg',
                'category_id' => $categories['Аксессуары'],
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 