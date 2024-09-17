<?php

// database/seeders/ProductCatalogSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductCatalogSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('product_catalogs')->insert([
                'name' => $faker->word,
                'price' => $faker->randomFloat(2, 1, 100), // Random price between 1 and 100
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
