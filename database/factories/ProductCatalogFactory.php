<?php

// database/factories/ProductCatalogFactory.php

namespace Database\Factories;

use App\Models\ProductCatalog;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCatalogFactory extends Factory
{
    protected $model = ProductCatalog::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 100), // Price between 1 and 100
        ];
    }
}
