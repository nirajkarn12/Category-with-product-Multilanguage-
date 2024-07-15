<?php
// database/seeders/ProductSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder {
    public function run() {
        $faker = Faker::create();

        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 0; $i < 5; $i++) { // Corrected loop syntax
                Product::create([
                    'name' => $faker->word,
                    'category_id' => $category->id
                ]);
            }
        }
    }
}
