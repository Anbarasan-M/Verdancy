<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'seller_id', 'stock', 'image_url', 'image_file', 'category_id',
    ];

    public function seller() {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
