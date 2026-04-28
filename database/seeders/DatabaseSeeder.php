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

        $this->call([
            FlowerSeeder::class,
            EventSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'username' => 'testuser',
                'password' => Hash::make('test1234'),
                'role' => 'user',
                'age' => 25,
                'gender' => 'Other',
                'civil_status' => 'Single',
                'mobile' => '09171234567',
                'address' => '123 Test Street',
                'zip' => '1000',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
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

        Product::truncate();

        Product::insert([
            ['name' => 'Blooming Embrace Bouquet', 'category' => 'Bouquet', 'price' => 1499.00, 'image_url' => 'products/blooming-embrace-bouquet.webp', 'description' => 'A lush bouquet of mixed blossoms with soft pinks and creams.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Citrus Kiss Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'image_url' => 'products/citrus-kiss-bouquet.webp', 'description' => 'A bright, refreshing arrangement of yellow and orange blooms.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Daisy Kiss Bouquet', 'category' => 'Bouquet', 'price' => 1099.00, 'image_url' => 'products/daisy-kiss-bouquet.webp', 'description' => 'A cheerful blend of daisies and greenery for everyday smiles.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emilia Bouquet', 'category' => 'Bouquet', 'price' => 1399.00, 'image_url' => 'products/emilia-bouquet.webp', 'description' => 'A graceful bouquet with elegant petals and delicate filler flowers.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emotions Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'image_url' => 'products/emotions-bouquet.webp', 'description' => 'A heartfelt arrangement designed to express warmth and care.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gerbera Joy Bouquet', 'category' => 'Bouquet', 'price' => 1249.00, 'image_url' => 'products/gerbera-joy-bouquet.jpg', 'description' => 'A vibrant gerbera-focused bouquet bursting with color.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lemon Sorbet Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'image_url' => 'products/lemon-sorbet-bouquet.webp', 'description' => 'A sunny citrus-inspired bouquet with soft pastel accents.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Liliana Bouquet', 'category' => 'Bouquet', 'price' => 1399.00, 'image_url' => 'products/liliana-bouquet.webp', 'description' => 'A stylish floral display centered around fragrant lilies.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Love Full In Bloom Bouquet', 'category' => 'Bouquet', 'price' => 1599.00, 'image_url' => 'products/love-full-in-bloom-bouquet.webp', 'description' => 'A romantic abundance of blooms in classic tones.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Love In Bloom Bouquet', 'category' => 'Bouquet', 'price' => 1499.00, 'image_url' => 'products/love-in-bloom-bouquet.jpg', 'description' => 'A tender bouquet crafted for special love moments.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Peachy Glow Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'image_url' => 'products/peachy-glow-bouquet.jpg', 'description' => 'A soft peach-hued bouquet with warm, elegant charm.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pink Delight Bouquet', 'category' => 'Bouquet', 'price' => 1199.00, 'image_url' => 'products/pink-delight-bouquet.jpg', 'description' => 'A playful pink arrangement bursting with joyful petals.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pink Love Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'image_url' => 'products/pink-love-bouquet.webp', 'description' => 'A dreamy pink bouquet made for romantic surprises.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pink Sweet Bouquet', 'category' => 'Bouquet', 'price' => 1199.00, 'image_url' => 'products/pink-sweet-bouquet.webp', 'description' => 'A sweet blush arrangement with delicate floral accents.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rose Romance', 'category' => 'Bouquet', 'price' => 1599.00, 'image_url' => 'products/Rose Romance.jpg', 'description' => 'A timeless romantic bouquet of luxurious rose blooms.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rosy Charm Bouquet', 'category' => 'Bouquet', 'price' => 1249.00, 'image_url' => 'products/rosy-charm-bouquet.jpg', 'description' => 'A charming mix of rosy tones for elegant gifting.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Royal Orchid Bouquet', 'category' => 'Bouquet', 'price' => 1699.00, 'image_url' => 'products/royal-orchid-bouquet.jpg', 'description' => 'A luxurious bouquet featuring premium orchids.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Simple Sweet Bouquet', 'category' => 'Bouquet', 'price' => 1099.00, 'image_url' => 'products/simple-sweet-bouquet.webp', 'description' => 'A minimal yet sweet arrangement for gentle gestures.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Stargazing Bloom Bouquet', 'category' => 'Bouquet', 'price' => 1599.00, 'image_url' => 'products/stargazing-bloom-bouquet.jpg', 'description' => 'An elegant bouquet inspired by starry night florals.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Summer Medley Bouquet', 'category' => 'Bouquet', 'price' => 1399.00, 'image_url' => 'products/summer-medley-bouquet.webp', 'description' => 'A lively mix of summer flowers in bright, warm hues.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sunshine Cheer Bouquet', 'category' => 'Bouquet', 'price' => 1099.00, 'image_url' => 'products/sunshine-cheer-bouquet.jpg', 'description' => 'A cheerful, sunlit bouquet to brighten any room.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sweet Petals Bouquet', 'category' => 'Bouquet', 'price' => 1199.00, 'image_url' => 'products/sweet-petals-bouquet.jpg', 'description' => 'A delicate pastel arrangement with airy, fragrant petals.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'White Rose Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'image_url' => 'products/white-rose-bouquet.jpg', 'description' => 'A classic bouquet of pure white roses for refined style.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wildest Dreams Bouquet', 'category' => 'Bouquet', 'price' => 1499.00, 'image_url' => 'products/wildest-dreams-bouquet.webp', 'description' => 'A dreamy bouquet of dramatic blooms and lush greenery.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
