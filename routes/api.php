<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);

// Route to create a new shopping list
Route::post('/shopping-lists', [ShoppingListController::class, 'store']);

// Route to change a product to an existing shopping list
Route::post('/shopping-lists/{id}/change-product-quantity', [ShoppingListController::class, 'changeProductQuantity']);

// Route to add a product to an existing shopping list
Route::post('/shopping-lists/{id}/add-product', [ShoppingListController::class, 'addProduct']);

// Route to remove a product to an existing shopping list
Route::post('/shopping-lists/{id}/remove-product', [ShoppingListController::class, 'removeProduct']);

// Route to retrieve a single shopping list by ID
Route::get('/shopping-lists/{id}', [ShoppingListController::class, 'show']);




// // Protected routes for shopping lists
// Route::middleware('auth:sanctum')->group(function () {
//     // Route to create a new shopping list
//     Route::post('/shopping-lists', [ShoppingListController::class, 'store']);

//     // Route to change a product in an existing shopping list
//     Route::post('/shopping-lists/{id}/change-product-quantity', [ShoppingListController::class, 'changeProductQuantity']);

//     // Route to add a product to an existing shopping list
//     Route::post('/shopping-lists/{id}/add-product', [ShoppingListController::class, 'addProduct']);

//     // Route to remove a product from an existing shopping list
//     Route::post('/shopping-lists/{id}/remove-product', [ShoppingListController::class, 'removeProduct']);

//     // Route to retrieve a single shopping list by ID
//     Route::get('/shopping-lists/{id}', [ShoppingListController::class, 'show']);
// });