<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Категориудыг нэрээр нь хайж ID-г нь авах (Эсвэл байхгүй бол үүсгэх)
        $bagts = Category::where('name', 'Багц')->first();
        $pizza = Category::where('name', 'Пицца')->first();
        $burger = Category::where('name', 'Бургер')->first();
        $undaa = Category::where('name', 'Ундаа')->first( );

        $categoryMap = [
            'bagts'  => $bagts->id,
            'pizza'  => $pizza->id,
            'burger' => $burger->id,
            'undaa'  => $undaa->id,
        ];

        $products = [
            ['name' => 'Хосын багц', 'category' => 'bagts', 'price' => 55000, 'image' => 'images/menu/couple_set.svg'],
            ['name' => 'Найзууд багц', 'category' => 'bagts', 'price' => 85000, 'image' => 'images/menu/friends_set.svg'],
            ['name' => 'Гэр бүлийн багц', 'category' => 'bagts', 'price' => 95000, 'image' => 'images/menu/family_set.svg'],
            ['name' => 'Пепперони Пицца', 'category' => 'pizza', 'price' => 28000, 'image' => 'images/menu/pepperoni.svg'],
            ['name' => 'Маргарита Пицца', 'category' => 'pizza', 'price' => 24000, 'image' => 'images/menu/margherita.svg'],
            ['name' => 'Махны цуглуулга', 'category' => 'pizza', 'price' => 32000, 'image' => 'images/menu/meat_lovers.svg'],
            ['name' => 'Хавайн Пицца', 'category' => 'pizza', 'price' => 29500, 'image' => 'images/menu/hawaiian.svg'],
            ['name' => 'Веган Пицца', 'category' => 'pizza', 'price' => 26000, 'image' => 'images/menu/vegan.svg'],

            ['name' => 'Сонгодог Бургер', 'category' => 'burger', 'price' => 12500, 'image' => 'images/menu/standart_burger.svg'],
            ['name' => 'Чизбургер', 'category' => 'burger', 'price' => 13500, 'image' => 'images/menu/double_cheese.svg'],
            ['name' => 'BBQ Бургер', 'category' => 'burger', 'price' => 15000, 'image' => 'images/menu/tusgai_burger.svg'],
            ['name' => 'Тахиан махтай', 'category' => 'burger', 'price' => 11000, 'image' => 'images/menu/chicken_burger.svg'],
            ['name' => 'Double Tower', 'category' => 'burger', 'price' => 19000, 'image' => 'images/menu/double_burger.svg'],

            ['name' => 'Coca Cola 1.5L', 'category' => 'undaa', 'price' => 4500, 'image' => 'images/menu/cola_1.5L.svg'],
            ['name' => 'Coca Cola 0.5L', 'category' => 'undaa', 'price' => 2500, 'image' => 'images/menu/cola_0.5L.svg'],
            ['name' => 'Orange Juice', 'category' => 'undaa', 'price' => 3500, 'image' => 'images/menu/lemonade.svg'],
            ['name' => 'Lipton Iced Tea', 'category' => 'undaa', 'price' => 3000, 'image' => 'images/menu/icedtea.svg'],
            ['name' => 'Цэвэр ус 0.5L', 'category' => 'undaa', 'price' => 1500, 'image' => 'images/menu/water.svg'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                [
                    'category_id' => $categoryMap[$product['category']], // Энд шинэ Map-аа ашиглана
                    'price'       => $product['price'],
                    'image'       => $product['image'],
                    'description' => $product['description'] ?? null,
                ]
            );
        }
    }
}