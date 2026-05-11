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
            ['name' => 'Багц', 'description' => 'Онцлох багцууд', 'icon' => 'package'],
            ['name' => 'Пицца', 'description' => 'Халуун пиццанууд', 'icon' => 'pizza'],
            ['name' => 'Бургер', 'description' => 'Амттай бургерууд', 'icon' => 'burger'],
            ['name' => 'Ундаа', 'description' => 'Согтууруулах ундаанууд', 'icon' => 'drink'],
            ['name' => 'Нэмэлт', 'description' => 'Нэмэлт бүтээгдэхүүн', 'icon' => 'extra'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['icon' => $category['icon']],
                $category
            );
        }
    }
}
