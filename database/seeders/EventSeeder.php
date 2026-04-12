<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'name' => 'Rustic Wedding',
                'slug' => 'rustic-wedding',
                'category' => 'Weddings',
                'image' => 'rustic_wedding.jpg',
                'images' => ['rustic_wedding1.jpg', 'rustic_wedding2.jpg', 'rustic_wedding3.jpg'],
            ],
            [
                'name' => '18th Birthday',
                'slug' => '18th-birthday',
                'category' => 'Birthdays',
                'image' => '18th_birthday.jpg',
                'images' => ['18th_birthday1.jpg', '18th_birthday2.jpg', '18th_birthday3.jpg'],
            ],
            [
                'name' => 'Corporate Gala',
                'slug' => 'corporate-gala',
                'category' => 'Others',
                'image' => 'corporate_gala.jpg',
                'images' => ['corporate_gala1.jpg', 'corporate_gala2.jpg', 'corporate_gala3.jpg'],
            ],
            [
                'name' => 'Garden Wedding',
                'slug' => 'garden-wedding',
                'category' => 'Weddings',
                'image' => 'garden_wedding.jpg',
                'images' => ['garden_wedding1.jpg', 'garden_wedding2.jpg', 'garden_wedding3.jpg'],
            ],
            [
                'name' => 'Debut Celebration',
                'slug' => 'debut-celebration',
                'category' => 'Birthdays',
                'image' => 'debut_celebration.jpg',
                'images' => ['debut_celebration1.jpg', 'debut_celebration2.jpg', 'debut_celebration3.jpg'],
            ],
            [
                'name' => 'Anniversary Party',
                'slug' => 'anniversary-party',
                'category' => 'Others',
                'image' => 'anniversary_party.jpg',
                'images' => ['anniversary_party1.jpg', 'anniversary_party2.jpg', 'anniversary_party3.jpg'],
            ],
        ];

        foreach ($events as $eventData) {
            $images = $eventData['images'];
            unset($eventData['images']);

            $event = Event::updateOrCreate(
                ['slug' => $eventData['slug']],
                $eventData
            );

            foreach ($images as $image) {
                EventImage::updateOrCreate(
                    ['event_id' => $event->id, 'image' => $image],
                    ['image' => $image]
                );
            }
        }
    }
}
