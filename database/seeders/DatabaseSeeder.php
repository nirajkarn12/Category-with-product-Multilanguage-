<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// database/seeders/DatabaseSeeder.php


class DatabaseSeeder extends Seeder {
    public function run() {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
