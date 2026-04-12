<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Blooming Embrace Bouquet', 'category' => 'Bouquet', 'price' => 1499.00, 'description' => 'A lush bouquet of mixed blossoms with soft pinks and creams.', 'image_url' => 'products/blooming-embrace-bouquet.webp'],
            ['name' => 'Citrus Kiss Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => 'A bright, refreshing arrangement of yellow and orange blooms.', 'image_url' => 'products/citrus-kiss-bouquet.webp'],
            ['name' => 'Daisy Kiss Bouquet', 'category' => 'Bouquet', 'price' => 1099.00, 'description' => 'A cheerful blend of daisies and greenery for everyday smiles.', 'image_url' => 'products/daisy-kiss-bouquet.webp'],
            ['name' => 'Emilia Bouquet', 'category' => 'Bouquet', 'price' => 1399.00, 'description' => 'A graceful bouquet with elegant petals and delicate filler flowers.', 'image_url' => 'products/emilia-bouquet.webp'],
            ['name' => 'Emotions Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => 'A heartfelt arrangement designed to express warmth and care.', 'image_url' => 'products/emotions-bouquet.webp'],
            ['name' => 'Gerbera Joy Bouquet', 'category' => 'Bouquet', 'price' => 1249.00, 'description' => 'A vibrant gerbera-focused bouquet bursting with color.', 'image_url' => 'products/gerbera-joy-bouquet.jpg'],
            ['name' => 'Lemon Sorbet Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => 'A sunny citrus-inspired bouquet with soft pastel accents.', 'image_url' => 'products/lemon-sorbet-bouquet.webp'],
            ['name' => 'Liliana Bouquet', 'category' => 'Bouquet', 'price' => 1399.00, 'description' => 'A stylish floral display centered around fragrant lilies.', 'image_url' => 'products/liliana-bouquet.webp'],
            ['name' => 'Love Full In Bloom Bouquet', 'category' => 'Bouquet', 'price' => 1599.00, 'description' => 'A romantic abundance of blooms in classic tones.', 'image_url' => 'products/love-full-in-bloom-bouquet.webp'],
            ['name' => 'Love In Bloom Bouquet', 'category' => 'Bouquet', 'price' => 1499.00, 'description' => 'A tender bouquet crafted for special love moments.', 'image_url' => 'products/love-in-bloom-bouquet.jpg'],
            ['name' => 'Peachy Glow Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => 'A soft peach-hued bouquet with warm, elegant charm.', 'image_url' => 'products/peachy-glow-bouquet.jpg'],
            ['name' => 'Pink Delight Bouquet', 'category' => 'Bouquet', 'price' => 1199.00, 'description' => 'A playful pink arrangement bursting with joyful petals.', 'image_url' => 'products/pink-delight-bouquet.jpg'],
            ['name' => 'Pink Love Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => 'A dreamy pink bouquet made for romantic surprises.', 'image_url' => 'products/pink-love-bouquet.webp'],
            ['name' => 'Pink Sweet Bouquet', 'category' => 'Bouquet', 'price' => 1199.00, 'description' => 'A sweet blush arrangement with delicate floral accents.', 'image_url' => 'products/pink-sweet-bouquet.webp'],
            ['name' => 'Rose Romance', 'category' => 'Bouquet', 'price' => 1599.00, 'description' => 'A timeless romantic bouquet of luxurious rose blooms.', 'image_url' => 'products/Rose Romance.jpg'],
            ['name' => 'Rosy Charm Bouquet', 'category' => 'Bouquet', 'price' => 1249.00, 'description' => 'A charming mix of rosy tones for elegant gifting.', 'image_url' => 'products/rosy-charm-bouquet.jpg'],
            ['name' => 'Royal Orchid Bouquet', 'category' => 'Bouquet', 'price' => 1699.00, 'description' => 'A luxurious bouquet featuring premium orchids.', 'image_url' => 'products/royal-orchid-bouquet.jpg'],
            ['name' => 'Simple Sweet Bouquet', 'category' => 'Bouquet', 'price' => 1099.00, 'description' => 'A minimal yet sweet arrangement for gentle gestures.', 'image_url' => 'products/simple-sweet-bouquet.webp'],
            ['name' => 'Stargazing Bloom Bouquet', 'category' => 'Bouquet', 'price' => 1599.00, 'description' => 'An elegant bouquet inspired by starry night florals.', 'image_url' => 'products/stargazing-bloom-bouquet.jpg'],
            ['name' => 'Summer Medley Bouquet', 'category' => 'Bouquet', 'price' => 1399.00, 'description' => 'A lively mix of summer flowers in bright, warm hues.', 'image_url' => 'products/summer-medley-bouquet.webp'],
            ['name' => 'Sunshine Cheer Bouquet', 'category' => 'Bouquet', 'price' => 1099.00, 'description' => 'A cheerful, sunlit bouquet to brighten any room.', 'image_url' => 'products/sunshine-cheer-bouquet.jpg'],
            ['name' => 'Sweet Petals Bouquet', 'category' => 'Bouquet', 'price' => 1199.00, 'description' => 'A delicate pastel arrangement with airy, fragrant petals.', 'image_url' => 'products/sweet-petals-bouquet.jpg'],
            ['name' => 'White Rose Bouquet', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => 'A classic bouquet of pure white roses for refined style.', 'image_url' => 'products/white-rose-bouquet.jpg'],
            ['name' => 'Wildest Dreams Bouquet', 'category' => 'Bouquet', 'price' => 1499.00, 'description' => 'A dreamy bouquet of dramatic blooms and lush greenery.', 'image_url' => 'products/wildest-dreams-bouquet.webp'],
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
