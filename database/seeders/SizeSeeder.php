<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Size::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Получаем категории
        $categoryRuzhya = Category::where('name', 'Ружья')->first();
        $categoryPatrony = Category::where('name', 'Патроны')->first();
        $categoryOptika = Category::where('name', 'Оптика')->first();
        $categoryAksessuary = Category::where('name', 'Аксессуары')->first();
        $categoryKamuFlazh = Category::where('name', 'Камуфляж')->first();
        $categoryTermoBelyo = Category::where('name', 'Термобельё')->first();
        $categoryObuv = Category::where('name', 'Обувь')->first();
        $categoryZashchita = Category::where('name', 'Защитная экипировка для охоты')->first();
        $categoryOdezhda = Category::where('name', 'Одежда')->first();

        // Создаём размеры для каждой категории
        if ($categoryRuzhya) {
            Size::create(['category_id' => $categoryRuzhya->id, 'size' => 'Калибр 12']);
            Size::create(['category_id' => $categoryRuzhya->id, 'size' => 'Калибр 16']);
            Size::create(['category_id' => $categoryRuzhya->id, 'size' => 'Калибр 20']);
            Size::create(['category_id' => $categoryRuzhya->id, 'size' => 'Калибр 28']);
        }

        if ($categoryPatrony) {
            Size::create(['category_id' => $categoryPatrony->id, 'size' => '12/70']);
            Size::create(['category_id' => $categoryPatrony->id, 'size' => '16/70']);
            Size::create(['category_id' => $categoryPatrony->id, 'size' => '20/70']);
            Size::create(['category_id' => $categoryPatrony->id, 'size' => '28/70']);
        }

        if ($categoryOptika) {
            Size::create(['category_id' => $categoryOptika->id, 'size' => '1x24']);
            Size::create(['category_id' => $categoryOptika->id, 'size' => '3x32']);
            Size::create(['category_id' => $categoryOptika->id, 'size' => '4x32']);
            Size::create(['category_id' => $categoryOptika->id, 'size' => '6x42']);
            Size::create(['category_id' => $categoryOptika->id, 'size' => '8x42']);
            Size::create(['category_id' => $categoryOptika->id, 'size' => '10x42']);
        }

        if ($categoryAksessuary) {
            Size::create(['category_id' => $categoryAksessuary->id, 'size' => 'Лямка для рюкзака']);
            Size::create(['category_id' => $categoryAksessuary->id, 'size' => 'Сумка для патронов']);
            Size::create(['category_id' => $categoryAksessuary->id, 'size' => 'Чехол для оружия']);
            Size::create(['category_id' => $categoryAksessuary->id, 'size' => 'Подсумок']);
        }

        if ($categoryKamuFlazh) {
            Size::create(['category_id' => $categoryKamuFlazh->id, 'size' => 'S']);
            Size::create(['category_id' => $categoryKamuFlazh->id, 'size' => 'M']);
            Size::create(['category_id' => $categoryKamuFlazh->id, 'size' => 'L']);
            Size::create(['category_id' => $categoryKamuFlazh->id, 'size' => 'XL']);
             Size::create(['category_id' => $categoryKamuFlazh->id, 'size' => 'XXL']);
            Size::create(['category_id' => $categoryKamuFlazh->id, 'size' => 'XXXL']);
        }

        if ($categoryTermoBelyo) {
            Size::create(['category_id' => $categoryTermoBelyo->id, 'size' => 'S']);
            Size::create(['category_id' => $categoryTermoBelyo->id, 'size' => 'M']);
            Size::create(['category_id' => $categoryTermoBelyo->id, 'size' => 'L']);
            Size::create(['category_id' => $categoryTermoBelyo->id, 'size' => 'XL']);
            Size::create(['category_id' => $categoryTermoBelyo->id, 'size' => 'XXL']);
            Size::create(['category_id' => $categoryTermoBelyo->id, 'size' => 'XXXL']);
        }

        if ($categoryObuv) {
            Size::create(['category_id' => $categoryObuv->id, 'size' => '37']);
            Size::create(['category_id' => $categoryObuv->id, 'size' => '38']);
            Size::create(['category_id' => $categoryObuv->id, 'size' => '39']);
            Size::create(['category_id' => $categoryObuv->id, 'size' => '40']);
            Size::create(['category_id' => $categoryObuv->id, 'size' => '41']);
            Size::create(['category_id' => $categoryObuv->id, 'size' => '42']);
            Size::create(['category_id' => $categoryObuv->id, 'size' => '43']);
            Size::create(['category_id' => $categoryObuv->id, 'size' => '44']);
            Size::create(['category_id' => $categoryObuv->id, 'size' => '45']);
            Size::create(['category_id' => $categoryObuv->id, 'size' => '46']);
        }

        if ($categoryZashchita) {
            Size::create(['category_id' => $categoryZashchita->id, 'size' => 'Защитные очки']);
            Size::create(['category_id' => $categoryZashchita->id, 'size' => 'Перчатки']);
            Size::create(['category_id' => $categoryZashchita->id, 'size' => 'Наушники']);
            Size::create(['category_id' => $categoryZashchita->id, 'size' => 'Маска']);
        }

        if ($categoryOdezhda) {
            Size::create(['category_id' => $categoryOdezhda->id, 'size' => 'XS']);
            Size::create(['category_id' => $categoryOdezhda->id, 'size' => 'S']);
            Size::create(['category_id' => $categoryOdezhda->id, 'size' => 'M']);
            Size::create(['category_id' => $categoryOdezhda->id, 'size' => 'L']);
            Size::create(['category_id' => $categoryOdezhda->id, 'size' => 'XL']);
            Size::create(['category_id' => $categoryOdezhda->id, 'size' => 'XXL']);
            Size::create(['category_id' => $categoryOdezhda->id, 'size' => 'XXXL']);
        }
    }
}
