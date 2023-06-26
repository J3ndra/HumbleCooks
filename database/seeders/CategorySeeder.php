<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Oriental Food',
            'Western Food',
            'Dessert',
            'Beverage',
            'Spice',
            'Vegetable',
            'Fruit',
            'Meat',
            'Seafood',
            'Dairy',
            'Grain',
            'Nuts',
            'Legumes',
            'Herbs',
            'Condiments',
            'Sauce',
            'Oil',
            'Other',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
