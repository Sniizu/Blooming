<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Category::create(['name' => 'Fresh Flower Bouquets', 'description' => 'A variety of fresh flowers arranged into beautiful bouquets']);
        Category::create(['name' => 'Birthday Bouquets', 'description' => 'Special bouquets designed for birthday celebrations']);
        Category::create(['name' => 'Romantic Bouquets', 'description' => "Bouquets for romantic occasions like anniversaries or Valentine's Day"]);
        Category::create(['name' => 'Wedding Bouquets', 'description' => 'Bouquets specifically for brides and wedding ceremonies']);
        Category::create(['name' => 'Seasonal Bouquets', 'description' => 'Bouquets made with flowers that are in season']);
        Category::create(['name' => 'Minimalist Bouquets', 'description' => 'Bouquets with simple and elegant designs']);
        Category::create(['name' => 'Bouquets with Gifts', 'description' => 'Bouquets combined with other gifts like chocolates, stuffed animals, or greeting cards']);
        Category::create(['name' => 'Flower Box', 'description' => 'Floral arrangements beautifully displayed in decorative boxes']);
        Category::create(['name' => 'Luxury Rose Boxes', 'description' => 'Elegant boxes filled with premium roses, often with long-lasting or preserved roses']);
        Category::create(['name' => 'Preserved Flower Boxes', 'description' => 'Boxes with preserved or eternal flowers that last longer than fresh blooms.']);
        Category::create(['name' => 'Gourmet Flower Boxes', 'description' => 'Flower boxes paired with gourmet treats like chocolates, wines, or snacks']);
        Category::create(['name' => 'Mixed Flower Boxes', 'description' => 'A variety of flowers arranged in a box, offering a colorful and diverse presentation']);
        Category::create(['name' => 'Artificial Bouquets', 'description' => 'Realistic-looking bouquets made from artificial flowers for all occasions']);
        $customCategory = Category::create(['name' => 'Custom', 'description' => 'Custom Made Flower']);

        Item::factory(33)->create();
        Item::create(
            [
                'id' => Item::generateId(),
                'name' => 'Custom Flower',
                'price' => 150000,
                'image' => "/asset/small.png",
                'category_id' => $customCategory->id,
                'description' => 'This is Custom Order',
            ]
        );
        User::create(
            [
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
                'verified_at' => Carbon::now(),
            ],

        );
        User::create(
            [
                'username' => 'user',
                'email' => 'user@gmail.com',
                'role' => 'customer',
                'password' => Hash::make('12345678'),
                'verified_at' => Carbon::now(),
            ],
        );
    }
}
