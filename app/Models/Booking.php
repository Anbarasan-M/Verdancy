<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'service_id', 'worker_id', 'booking_date','booking_time', 'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function worker() {
        return $this->belongsTo(User::class, 'worker_id');
    }
}
