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
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'age' => 25,
            'gender' => 'Other',
            'civil_status' => 'Single',
            'mobile' => '09991234567',
            'address' => '123 Test Street',
            'zip' => '1000',
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

        $this->call(ProductSeeder::class);
    }
}
