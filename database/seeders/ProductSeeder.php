<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    use App\Models\Product;

public function run(): void
{
    Product::create([
        'name' => 'Кимчи Порк Багц',
        'category' => 'bagts',
        'price' => 55000,
        'image' => 'https://via.placeholder.com/300x150',
    ]);

    Product::create([
        'name' => 'Мах сонирхогчдын пицца',
        'category' => 'pizza',
        'price' => 25000,
        'image' => 'https://via.placeholder.com/300x150',
    ]);
    
    Product::create([
        'name' => 'Pepsi 1.5L',
        'category' => 'undaa',
        'price' => 45000,
        'image' => 'https://via.placeholder.com/300x150',
    ]);
}
}
