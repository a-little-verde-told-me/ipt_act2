<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
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
            ['name' => 'Rose Romance', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => 'A romantic bouquet of 12 red roses wrapped with greenery.', 'image_url' => 'Rose Romance.jpg'],
            ['name' => 'Blush Dreams', 'category' => 'Bouquet', 'price' => 1199.00, 'description' => 'A soft pink bouquet featuring roses and baby’s breath.', 'image_url' => 'Blush Dreams.jpg'],
            ['name' => 'Sunshine Cheer', 'category' => 'Bouquet', 'price' => 1099.00, 'description' => 'A cheerful arrangement of sunflowers and daisies.', 'image_url' => 'Sunshine Cheer.jpg'],
            ['name' => 'Elegant White', 'category' => 'Bouquet', 'price' => 1399.00, 'description' => 'A graceful white bouquet with lilies and roses.', 'image_url' => 'Elegant White.jpg'],
            ['name' => 'Pastel Mix', 'category' => 'Bouquet', 'price' => 999.00, 'description' => 'A gentle pastel bouquet of tulips and carnations.', 'image_url' => 'Pastel Mix.jpg'],
            ['name' => 'Spring Garden', 'category' => 'Bouquet', 'price' => 1499.00, 'description' => 'A seasonal mixed bouquet inspired by spring blooms.', 'image_url' => 'Spring Garden.jpg'],
            ['name' => 'Royal Orchid', 'category' => 'Bouquet', 'price' => 1699.00, 'description' => 'A luxurious bouquet centered around premium orchids.', 'image_url' => 'Royal Orchid.jpg'],
            ['name' => 'Gerbera Joy', 'category' => 'Bouquet', 'price' => 999.00, 'description' => 'A joyful bouquet of gerbera daisies with fresh greenery.', 'image_url' => 'Gerbera Joy.jpg'],
            ['name' => 'Love in Bloom', 'category' => 'Bouquet', 'price' => 1349.00, 'description' => 'A romantic red and white rose bouquet.', 'image_url' => 'Love in Bloom.jpg'],
            ['name' => 'Rustic Charm', 'category' => 'Bouquet', 'price' => 999.00, 'description' => 'A rustic bouquet of daisies and eucalyptus.', 'image_url' => 'Rustic Charm.jpg'],
            ['name' => 'Peachy Glow', 'category' => 'Bouquet', 'price' => 1199.00, 'description' => 'A warm peach rose bouquet with soft accents.', 'image_url' => 'Peachy Glow.jpg'],
            ['name' => 'Classic Sympathy', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => 'A gentle bouquet of white lilies and carnations.', 'image_url' => 'Classic Sympathy.jpg'],
            ['name' => 'Stargazing Bloom', 'category' => 'Bouquet', 'price' => 1599.00, 'description' => 'An elegant bouquet of stargazer lilies and roses.', 'image_url' => 'Stargazing Bloom.jpg'],
            ['name' => 'Pink Delight', 'category' => 'Bouquet', 'price' => 1199.00, 'description' => 'A playful pink bouquet with roses and delicate fillers to celebrate special moments.', 'image_url' => 'pink_delight.jpg'],
            ['name' => 'White Rose', 'category' => 'Bouquet', 'price' => 1299.00, 'description' => 'A crisp white rose bouquet wrapped in elegant paper for timeless gifting.', 'image_url' => 'white_rose.jpg'],
            ['name' => 'Rosy Charm', 'category' => 'Bouquet', 'price' => 1249.00, 'description' => 'A charming bouquet of rosy blooms for a romantic and refined look.', 'image_url' => 'rosy_charm.jpg'],
            ['name' => 'Sweet Petals', 'category' => 'Bouquet', 'price' => 1199.00, 'description' => 'A soft pastel bouquet with sweet petals and airy fillers.', 'image_url' => 'sweet_petals.jpg'],
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
