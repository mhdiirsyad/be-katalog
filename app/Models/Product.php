<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function seller() {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }
}
