<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'seller_id', 'category_id', 'name', 'weight', 
        'stock', 'price', 'photo', 'rating'
    ];

    // Relasi ke Seller
    public function seller() {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }

    // Relasi ke Category
    public function category() {
        return $this->belongsTo(Category::class);
    }
}