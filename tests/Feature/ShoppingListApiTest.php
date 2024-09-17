<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ShoppingList;

class ShoppingListStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_new_shopping_list()
    {
        // Send POST request to create a new shopping list
        $response = $this->postJson('/api/shopping-lists');

        // Assert the response status code is 201 (Created)
        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Shopping list created successfully',
                 ]);

        // Retrieve the ID of the newly created shopping list from the response
        $newShoppingListId = $response->json('data.id');

        // Assert that the new shopping list is in the database
        $this->assertDatabaseHas('shopping_lists', [
            'id' => $newShoppingListId,
        ]);

        $response->assertJsonFragment([
            'id' => $newShoppingListId,
        ]);
    }
}


