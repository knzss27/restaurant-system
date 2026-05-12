<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(
            CategorySeeder::class,ProductSeeder::class);
        

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '+976 88123456',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
        
    }
}
