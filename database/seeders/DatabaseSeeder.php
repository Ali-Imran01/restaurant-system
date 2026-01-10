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
        \App\Models\OrderItem::truncate();
        \App\Models\Order::truncate();
        \App\Models\MenuItem::truncate();
        \App\Models\Category::truncate();
        \App\Models\Table::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $restaurant = \App\Models\Restaurant::updateOrCreate(
            ['name' => 'The Grand Bistro'],
            [
                'address' => '123 Food Street, Tasty City',
            ]
        );

        $admin = \App\Models\User::updateOrCreate(
            ['email' => 'admin@restoqr.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'restaurant_id' => $restaurant->id,
            ]
        );

        // Create 10 Tables
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Table::create([
                'table_number' => (string)$i, 
                'restaurant_id' => $restaurant->id,
                'qr_token' => \Illuminate\Support\Str::random(32)
            ]);
        }

        $categories = [
            'Food' => 10,
            'Drinks' => 15,
            'Sides' => 10,
            'Dessert' => 7,
            'Add-ons' => 5,
        ];

        $mockItems = [
            'Food' => ['Nasi Lemak Special', 'Chicken Chop', 'Beef Burger', 'Spaghetti Bolognese', 'Fish and Chips', 'Char Kway Teow', 'Laksa Nyonya', 'Grilled Salmon', 'Lamb Chop', 'Mee Goreng Mamak'],
            'Drinks' => ['Teh Tarik', 'Kopi O', 'Iced Lemon Tea', 'Mango Smoothie', 'Watermelon Juice', 'Carrot Milk', 'Fresh Orange', 'Hot Chocolate', 'Latte', 'Cappuccino', 'Matcha Latte', 'Pink Lemonade', 'Soda Gembira', 'Coke', 'Sprite'],
            'Sides' => ['French Fries', 'Garlic Bread', 'Onion Rings', 'Coleslaw', 'Mashed Potato', 'Chicken Wings', 'Nuggets', 'Potato Wedges', 'Cheese Fries', 'Truffle Fries'],
            'Dessert' => ['Chocolate Lava Cake', 'New York Cheesecake', 'Tiramisu', 'Creme Brulee', 'Ice Cream Sundae', 'Brownie with Ice Cream', 'Fruit Platter'],
            'Add-ons' => ['Extra Cheese', 'Fried Egg', 'Extra Sauce', 'Steam Rice', 'Chicken Slice'],
        ];

        $catIndex = 0;
        foreach ($categories as $catName => $count) {
            $category = \App\Models\Category::create([
                'restaurant_id' => $restaurant->id,
                'name' => $catName,
                'sort_order' => $catIndex++
            ]);

            for ($i = 0; $i < $count; $i++) {
                $itemName = $mockItems[$catName][$i] ?? ($catName . ' Item ' . ($i + 1));
                \App\Models\MenuItem::create([
                    'category_id' => $category->id, 
                    'name' => $itemName,
                    'description' => 'Delicious ' . $itemName . ' prepared with fresh ingredients.',
                    'price' => rand(5, 50) + (rand(0, 9) / 10),
                    'is_available' => true,
                    'image_url' => 'https://images.unsplash.com/photo-'.(1510000000000 + rand(1000000, 9000000)).'?auto=format&fit=crop&w=400&h=400&q=80'
                ]);
            }
        }
    }
}
