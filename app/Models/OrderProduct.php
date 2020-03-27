<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'product_to_order';

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            ->with('category');
    }
}
