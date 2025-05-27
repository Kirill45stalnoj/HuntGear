<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

class ProductSizeSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_size')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Получаем все продукты
        $products = Product::all();

        foreach ($products as $product) {
            // Получаем все размеры для категории продукта
            $sizes = Size::where('category_id', $product->category_id)->get();
            
            if ($sizes->isNotEmpty()) {
                // Связываем продукт со всеми доступными размерами его категории
                foreach ($sizes as $size) {
                    $product->sizes()->attach($size->id);
                }
            }
        }
    }
} 