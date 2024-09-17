<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCatalog extends Model
{

    use HasFactory;
    
    protected $fillable = ['name', 'price'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}


