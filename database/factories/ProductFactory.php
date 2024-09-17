<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\ShoppingList;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'shopping_list_id' => ShoppingList::factory(), 
            'product_catalog_id' => ProductCatalog::factory(), 
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 1, 100), 
        ];
    }
}
