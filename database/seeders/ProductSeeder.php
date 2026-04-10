<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Paste image links in "image_url" (full URL). Replace PASTE_URL_HERE per item.
        $items = [
            // Flowers (for customization)
            ['name' => 'Red Rose', 'category' => 'Flower', 'price' => 120.00, 'description' => 'Classic red rose stem.', 'image_url' => 'Red Rose.jpg'],
            ['name' => 'White Rose', 'category' => 'Flower', 'price' => 120.00, 'description' => 'Elegant white rose stem.', 'image_url' => 'White Rose.jpg'],
            ['name' => 'Pink Rose', 'category' => 'Flower', 'price' => 120.00, 'description' => 'Soft pink rose stem.', 'image_url' => 'Pink Rose.jpg'],
            ['name' => 'Tulip', 'category' => 'Flower', 'price' => 90.00, 'description' => 'Fresh tulip stem.', 'image_url' => 'Tulip.jpg'],
            ['name' => 'Sunflower', 'category' => 'Flower', 'price' => 110.00, 'description' => 'Bright sunflower stem.', 'image_url' => 'Sunflower.jpg'],
            ['name' => 'Lily', 'category' => 'Flower', 'price' => 140.00, 'description' => 'Fragrant lily stem.', 'image_url' => 'Lily.jpg'],
            ['name' => 'Carnation', 'category' => 'Flower', 'price' => 70.00, 'description' => 'Long-lasting carnation stem.', 'image_url' => 'Carnation.jpg'],
            ['name' => 'Daisy', 'category' => 'Flower', 'price' => 65.00, 'description' => 'Cheerful daisy stem.', 'image_url' => 'Daisy.jpg'],
            ['name' => 'Gerbera Daisy', 'category' => 'Flower', 'price' => 85.00, 'description' => 'Vibrant gerbera daisy stem.', 'image_url' => 'Gerbera Daisy.jpg'],
            ['name' => 'Baby’s Breath', 'category' => 'Flower', 'price' => 60.00, 'description' => 'Filler blooms for airy bouquets.', 'image_url' => 'Babys Breath.jpg'],
            ['name' => 'Orchid', 'category' => 'Flower', 'price' => 180.00, 'description' => 'Premium orchid stem.', 'image_url' => 'Orchid.jpg'],
            ['name' => 'Chrysanthemum', 'category' => 'Flower', 'price' => 75.00, 'description' => 'Full-bodied mum bloom.', 'image_url' => 'Chrysanthemum.jpg'],
            ['name' => 'Stargazer Lily', 'category' => 'Flower', 'price' => 160.00, 'description' => 'Starry stargazer lily stem.', 'image_url' => 'Stargazer Lily.jpg'],
            // Bouquets
            ['name' => 'Rose Romance', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => '12 red roses with greenery.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Blush Dreams', 'category' => 'Bouquet', 'price' => 1199.00, 'description' => 'Pink roses with baby’s breath.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Sunshine Cheer', 'category' => 'Bouquet', 'price' => 1099.00, 'description' => 'Sunflowers and daisies mix.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Elegant White', 'category' => 'Bouquet', 'price' => 1399.00, 'description' => 'White lilies and roses.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Pastel Mix', 'category' => 'Bouquet', 'price' => 999.00, 'description' => 'Soft tulips and carnations.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Spring Garden', 'category' => 'Bouquet', 'price' => 1499.00, 'description' => 'Seasonal mixed blooms.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Royal Orchid', 'category' => 'Bouquet', 'price' => 1699.00, 'description' => 'Orchid centerpiece bouquet.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Gerbera Joy', 'category' => 'Bouquet', 'price' => 999.00, 'description' => 'Gerbera daisies with greenery.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Love in Bloom', 'category' => 'Bouquet', 'price' => 1349.00, 'description' => 'Red and white roses.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Rustic Charm', 'category' => 'Bouquet', 'price' => 999.00, 'description' => 'Daisies with eucalyptus.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Peachy Glow', 'category' => 'Bouquet', 'price' => 1199.00, 'description' => 'Peach roses and mums.', 'image_url' => 'PASTE_URL_HERE'],
            ['name' => 'Classic Sympathy', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => 'White lilies and carnations.', 'image_url' => 'PASTE_URL_HERE'],
        ];

        foreach ($items as $item) {
            $imageUrl = $item['image_url'] ?? null;
            if ($imageUrl === 'PASTE_URL_HERE' || $imageUrl === '') {
                $imageUrl = null;
            }
            Product::updateOrCreate(
                ['name' => $item['name']],
                [
                    'category' => $item['category'],
                    'price' => $item['price'],
                    'description' => $item['description'],
                    'image_url' => $imageUrl,
                ]
            );
        }
    }
}
