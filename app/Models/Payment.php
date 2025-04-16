<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'razorpay_payment_id', 'user_id', 'order_id', 'booking_id', 'amount', 'payment_method', 'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}

