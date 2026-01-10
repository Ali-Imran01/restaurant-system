<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks for truncation
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\User::truncate();
        \App\Models\Restaurant::truncate();
        \App\Models\OrderItem::truncate();
        \App\Models\Order::truncate();
        \App\Models\MenuItem::truncate();
        \App\Models\Category::truncate();
        \App\Models\Table::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Create the SUPER ADMIN
        \App\Models\User::create([
            'name' => 'Platform Owner',
            'email' => 'super_admin@restoqr.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'restaurant_id' => null, // Super admins don't belong to one restaurant
        ]);

        // 2. Create example restaurants
        $restaurants = [
            [
                'name' => 'The Grand Bistro',
                'address' => '123 Gourmet St, Food City',
                'owner_email' => 'bistro@owner.com',
                'items' => ['Truffle Pasta', 'Grilled Salmon', 'Ribeye Steak'],
                'cat' => 'Fine Dining'
            ],
            [
                'name' => 'Burger Barn',
                'address' => '45 Main Road, Hunger Town',
                'owner_email' => 'burger@owner.com',
                'items' => ['Monster Burger', 'Cheese Fries', 'Onion Rings'],
                'cat' => 'Fast Food'
            ]
        ];

        foreach ($restaurants as $resData) {
            $restaurant = \App\Models\Restaurant::create([
                'name' => $resData['name'],
                'address' => $resData['address'],
            ]);

            // Create Owner for each restaurant
            \App\Models\User::create([
                'name' => $resData['name'] . ' Manager',
                'email' => $resData['owner_email'],
                'password' => bcrypt('password'),
                'role' => 'admin',
                'restaurant_id' => $restaurant->id,
            ]);

            // Create Tables for each
            for ($i = 1; $i <= 5; $i++) {
                \App\Models\Table::create([
                    'table_number' => (string)$i,
                    'restaurant_id' => $restaurant->id,
                    'qr_token' => \Illuminate\Support\Str::random(32)
                ]);
            }

            // Create Categories & Items for each
            $category = \App\Models\Category::create([
                'restaurant_id' => $restaurant->id,
                'name' => $resData['cat'],
                'sort_order' => 0
            ]);

            foreach ($resData['items'] as $itemName) {
                \App\Models\MenuItem::create([
                    'restaurant_id' => $restaurant->id, // Critical for denormalization
                    'category_id' => $category->id,
                    'name' => $itemName,
                    'description' => 'A famous dish from ' . $resData['name'],
                    'price' => rand(15, 45),
                    'is_available' => true,
                    'image_url' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&h=400&q=80'
                ]);
            }
        }
    }
}
