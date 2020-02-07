<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = [];

    public function resources()
    {
        return $this->hasMany('App\Models\ProductResource', 'product_id');
    }
}
