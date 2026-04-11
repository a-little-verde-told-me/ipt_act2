<?php

namespace Database\Seeders;

use App\Models\Product;
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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'age' => 30,
            'gender' => 'Other',
            'civil_status' => 'Single',
            'mobile' => '09990000000',
            'address' => 'Admin Office Address',
            'zip' => '0000',
        ]);

        Product::insert([
            [
                'name' => 'Sweet Petals',
                'category' => 'Signature',
                'price' => 1299.00,
                'image_url' => 'sweet_petals.jpg',
                'description' => 'Soft pink petals arranged for a delicate and romantic gift.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'White Rose Elegance',
                'category' => 'Classic',
                'price' => 1599.00,
                'image_url' => 'white_rose.jpg',
                'description' => 'A timeless bouquet of white roses for elegant celebrations.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rosy Charm',
                'category' => 'Romantic',
                'price' => 1399.00,
                'image_url' => 'rosy_charm.jpg',
                'description' => 'A charming mix of rosy blooms perfect for special moments.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pink Delight',
                'category' => 'Fresh Picks',
                'price' => 1499.00,
                'image_url' => 'pink_delight.jpg',
                'description' => 'A cheerful pink arrangement with modern floral accents.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
