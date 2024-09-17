<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{

    use HasFactory;

    protected $fillable = ['shopping_list_id', 'product_catalog_id', 'quantity', 'price'];

    public function shoppingList()
    {
        return $this->belongsTo(ShoppingList::class);
    }

    public function productCatalog()
    {
        return $this->belongsTo(ProductCatalog::class);
    }
}
