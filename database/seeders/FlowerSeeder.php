<?php

namespace Database\Seeders;

use App\Models\Flower;
use Illuminate\Database\Seeder;

class FlowerSeeder extends Seeder
{
    public function run(): void
    {
        $flowers = [
            ['name' => 'Cosmos', 'image' => 'flower1.jpg', 'color' => 'pink'],
            ['name' => 'Indian Paintbrush', 'image' => 'flower2.jpg', 'color' => 'red'],
            ['name' => 'Bluebonnet', 'image' => 'flower3.jpg', 'color' => 'blue'],
            ['name' => 'Wild Bergamot', 'image' => 'flower4.jpg', 'color' => 'purple'],
            ['name' => 'Dahlia', 'image' => 'flower5.jpg', 'color' => 'red'],
            ['name' => 'Zinnia', 'image' => 'flower6.jpg', 'color' => 'pink'],
            ['name' => 'Ranunculus', 'image' => 'flower7.jpg', 'color' => 'orange'],
            ['name' => 'Larkspur', 'image' => 'flower8.jpg', 'color' => 'blue'],
            ['name' => 'Chrysanthemum', 'image' => 'flower9.jpg', 'color' => 'yellow'],
            ['name' => 'Anemone', 'image' => 'flower10.jpg', 'color' => 'purple'],
            ['name' => 'Celosia', 'image' => 'flower11.jpg', 'color' => 'yellow'],
            ['name' => 'Gladiolus', 'image' => 'flower12.jpg', 'color' => 'orange'],
            ['name' => 'Gomphrena', 'image' => 'flower13.jpg', 'color' => 'pink'],
            ['name' => 'Sunflower', 'image' => 'flower14.jpg', 'color' => 'yellow'],
            ['name' => 'Craspedia', 'image' => 'flower15.jpg', 'color' => 'yellow'],
            ['name' => 'Gerbera Daisy', 'image' => 'flower16.jpg', 'color' => 'pink'],
            ['name' => 'Snapdragon', 'image' => 'flower17.jpg', 'color' => 'pink'],
            ['name' => 'Bells of Ireland', 'image' => 'flower18.jpg', 'color' => 'green'],
            ['name' => 'Stock', 'image' => 'flower19.jpg', 'color' => 'purple'],
            ['name' => 'Strawflower', 'image' => 'flower20.jpg', 'color' => 'pink'],
            ['name' => 'Nigella', 'image' => 'flower21.jpg', 'color' => 'blue'],
            ['name' => 'Morning Glory', 'image' => 'flower22.jpg', 'color' => 'blue'],
            ['name' => 'Lobelia', 'image' => 'flower23.jpg', 'color' => 'purple'],
            ['name' => 'Verbena', 'image' => 'flower24.jpg', 'color' => 'pink'],
            ['name' => 'Dusty Miller', 'image' => 'flower25.jpg', 'color' => 'yellow'],
            ['name' => 'Sweet Alyssum', 'image' => 'flower26.jpg', 'color' => 'white'],
            ['name' => 'Browallia', 'image' => 'flower27.jpg', 'color' => 'purple'],
            ['name' => 'Torenia', 'image' => 'flower28.jpg', 'color' => 'white'],
            ['name' => 'Gazania', 'image' => 'flower29.jpg', 'color' => 'yellow'],
            ['name' => 'Nicotiana', 'image' => 'flower30.jpg', 'color' => 'pink'],
            ['name' => 'Nasturtium', 'image' => 'flower31.jpg', 'color' => 'orange'],
            ['name' => 'Alyssum', 'image' => 'flower32.jpg', 'color' => 'white'],
        ];

        foreach ($flowers as $flower) {
            Flower::updateOrCreate(
                ['name' => $flower['name']],
                $flower
            );
        }
    }
}
