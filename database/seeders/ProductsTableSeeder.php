<?php

// database/seeders/ProductsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ShoppingList;
use App\Models\ProductCatalog;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        // Ensure there are existing ShoppingLists and ProductCatalogs
        $shoppingLists = ShoppingList::factory()->count(5)->create();
        $productCatalogs = ProductCatalog::factory()->count(10)->create();

        // Create products for each shopping list
        foreach ($shoppingLists as $shoppingList) {
            foreach ($productCatalogs->random(3) as $productCatalog) {
                Product::create([
                    'shopping_list_id' => $shoppingList->id,
                    'product_catalog_id' => $productCatalog->id,
                    'quantity' => rand(1, 10), // Random quantity between 1 and 10
                    'price' => $productCatalog->price, // Price from the catalog
                ]);
            }
        }
    }
}
