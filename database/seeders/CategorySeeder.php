<?php
// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder {
    public function run() {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {  // Corrected loop syntax
            Category::create(['name' => $faker->word]);
        }
    }
}
