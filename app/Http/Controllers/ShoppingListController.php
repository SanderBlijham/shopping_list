<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use App\Models\ProductCatalog;
use App\Models\Product;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    // Create a new shopping list
    public function store(Request $request)
    {
        $request->validate([]);

        // Create the shopping list (only created_at and updated_at will be populated)
        $shoppingList = ShoppingList::create();

        return response()->json([
            'message' => 'Shopping list created successfully',
            'data' => $shoppingList,
        ], 201);
    }

    // Change product quantity to an existing shopping list
    public function changeProductQuantity(Request $request, $id)
    {
        $request->validate([
            'product_catalog_id' => 'required|exists:product_catalogs,id',
            'quantity' => 'required|integer|min:1', // Ensure quantity is at least 1
        ]);

        $shoppingList = ShoppingList::findOrFail($id);
        $catalogProduct = ProductCatalog::findOrFail($request->product_catalog_id);

        // Create or update the product in the shopping list
        $existingProduct = Product::where('shopping_list_id', $shoppingList->id)
                                ->where('product_catalog_id', $catalogProduct->id)
                                ->first();

        if ($existingProduct) {
            // If the product already exists in the shopping list, update the quantity
            $existingProduct->quantity = $request->quantity;
            $existingProduct->price = $catalogProduct->price; // Ensure price is updated
            $existingProduct->save();
        } else {
            // Otherwise, create a new product entry
            Product::create([                                       
                'shopping_list_id' => $shoppingList->id,
                'product_catalog_id' => $catalogProduct->id,
                'quantity' => $request->quantity,
                'price' => $catalogProduct->price,
            ]);
        }

        return response()->json([
            'message' => 'Product added to the shopping list successfully',
            'data' => $shoppingList->load('products.productCatalog'),
        ], 200);
    }

    public function addProduct(Request $request, $id)
    {
        $request->validate([
            'product_catalog_id' => 'required|exists:product_catalogs,id',
        ]);

        $shoppingList = ShoppingList::findOrFail($id);
        $catalogProduct = ProductCatalog::findOrFail($request->product_catalog_id);

        // Find if the product already exists in the shopping list
        $existingProduct = Product::where('shopping_list_id', $shoppingList->id)
                                ->where('product_catalog_id', $catalogProduct->id)
                                ->first();

        if ($existingProduct) {
            // If the product already exists, increment its quantity by 1
            $existingProduct->quantity += 1;
            $existingProduct->price = $catalogProduct->price; // Ensure price is updated
            $existingProduct->save();
        } else {
            // Otherwise, create a new product entry with quantity 1
            Product::create([
                'shopping_list_id' => $shoppingList->id,
                'product_catalog_id' => $catalogProduct->id,
                'quantity' => 1,
                'price' => $catalogProduct->price,
            ]);
        }

        return response()->json([
            'message' => 'Product quantity updated successfully',
            'data' => $shoppingList->load('products.productCatalog'),
        ], 200);
    }    

    public function removeProduct(Request $request, $id)
    {
        $request->validate([
            'product_catalog_id' => 'required|exists:product_catalogs,id',
        ]);

        $shoppingList = ShoppingList::findOrFail($id);
        $catalogProduct = ProductCatalog::findOrFail($request->product_catalog_id);

        // Find if the product already exists in the shopping list
        $existingProduct = Product::where('shopping_list_id', $shoppingList->id)
                                ->where('product_catalog_id', $catalogProduct->id)
                                ->first();

        if ($existingProduct) {
            // If the product exists, check if the quantity is greater than 0 before decreasing
            if ($existingProduct->quantity > 1) {
                // Decrease the quantity by 1 if it's greater than 1
                $existingProduct->quantity -= 1;
                $existingProduct->price = $catalogProduct->price; // Ensure price is updated
                $existingProduct->save();
            } else {
                // If quantity is 1, remove the product from the shopping list
                $existingProduct->delete();
            }
        } else {
            // If the product does not exist in the shopping list
            return response()->json([
                'message' => 'Product does not exist in the shopping list',
            ], 404);
        }

        return response()->json([
            'message' => 'Product quantity updated successfully',
            'data' => $shoppingList->load('products.productCatalog'),
        ], 200);
    } 

    // Retrieve a single shopping list
    public function show($id)
    {
        // Retrieve the shopping list with its associated products and their product catalog information
        $shoppingList = ShoppingList::with('products.productCatalog')->find($id);

        // Check if the shopping list exists
        if (!$shoppingList) {
            return response()->json(['message' => 'Shopping list not found'], 404);
        }

        // Return the shopping list and its related products
        return response()->json([
            'data' => $shoppingList,
        ], 200);
    }

}
