<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function firstProduct()
    {
        return $this->hasOne(Product::class)->latest(); // Fetch the latest product
    }
}

