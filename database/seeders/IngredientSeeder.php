<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 0; $i < 10; $i++) {
                $ingredient = new Ingredient();
                $ingredient->name = $faker->unique()->word;
                $ingredient->image = $faker->imageUrl(200, 200);
                $ingredient->description = $faker->paragraph;
                $ingredient->category_id = $category->id;
                $ingredient->save();
            }
        }
    }
}
