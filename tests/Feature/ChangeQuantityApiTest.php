<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ProductCatalog;
use App\Models\ShoppingList;
use App\Models\Product;

class ChangeProductQuantityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create multiple ShoppingLists and ProductCatalogs
        $this->shoppingLists = ShoppingList::factory()->count(5)->create();
        $this->productCatalogs = ProductCatalog::factory()->count(10)->create();

        // Create products for each shopping list and product catalog
        foreach ($this->shoppingLists as $shoppingList) {
            foreach ($this->productCatalogs->random(3) as $productCatalog) {
                Product::create([
                    'shopping_list_id' => $shoppingList->id,
                    'product_catalog_id' => $productCatalog->id,
                    'quantity' => rand(1, 10), 
                    'price' => $productCatalog->price, 
                ]);
            }
        }
    }

    /** @test */
    public function it_can_update_quantity_of_an_existing_product()
    {
        $shoppingList = $this->shoppingLists->first(); 
        $productCatalog = $this->productCatalogs->random(); 
        
        // Ensure a product exists for this shopping list and product catalog
        $product = Product::where([
            'shopping_list_id' => $shoppingList->id,
            'product_catalog_id' => $productCatalog->id
        ])->first();

        if (!$product) {
            $product = Product::create([
                'shopping_list_id' => $shoppingList->id,
                'product_catalog_id' => $productCatalog->id,
                'quantity' => 2, // Initial quantity
                'price' => $productCatalog->price,
            ]);
        }

        $response = $this->json('POST', '/api/shopping-lists/'.$shoppingList->id.'/change-product-quantity', [
            'product_catalog_id' => $productCatalog->id,
            'quantity' => 5,
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Product added to the shopping list successfully',
                ]);

        $this->assertDatabaseHas('products', [
            'shopping_list_id' => $shoppingList->id,
            'product_catalog_id' => $productCatalog->id,
            'quantity' => 5,
        ]);
    }

    /** @test */
    public function it_can_add_a_new_product_to_the_shopping_list()
    {
        $shoppingList = $this->shoppingLists->first(); // Get the first shopping list
        $productCatalog = $this->productCatalogs->random(); // Get a random product catalog

        $response = $this->json('POST', '/api/shopping-lists/'.$shoppingList->id.'/change-product-quantity', [
            'product_catalog_id' => $productCatalog->id,
            'quantity' => 3,
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Product added to the shopping list successfully',
                ]);

        $this->assertDatabaseHas('products', [
            'shopping_list_id' => $shoppingList->id,
            'product_catalog_id' => $productCatalog->id,
            'quantity' => 3,
        ]);
    }
}
