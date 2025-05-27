<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'user_id' => 2, // Test User
                'product_id' => 1, // Куртка
                'review' => 'Отличная куртка, очень теплая и удобная. Качество на высоте!',
                'rating' => 5,
            ],
            [
                'user_id' => 3, // User 1
                'product_id' => 1,
                'review' => 'Хорошая куртка, но немного тяжеловата.',
                'rating' => 4,
            ],
            [
                'user_id' => 2,
                'product_id' => 2, // Сапоги
                'review' => 'Сапоги действительно водонепроницаемые, очень доволен покупкой.',
                'rating' => 5,
            ],
            [
                'user_id' => 4, // User 2
                'product_id' => 3, // Рюкзак
                'review' => 'Вместительный рюкзак, удобные карманы.',
                'rating' => 4,
            ],
            [
                'user_id' => 5, // User 3
                'product_id' => 4, // Бинокль
                'review' => 'Отличная оптика, четкое изображение даже в сумерках.',
                'rating' => 5,
            ],
            [
                'user_id' => 6, // User 4
                'product_id' => 5, // Нож
                'review' => 'Качественный нож, хорошо держит заточку.',
                'rating' => 5,
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
} 