<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Auth\Passwords\CanResetPassword;

class User extends Authenticatable
{
    use Notifiable, CanResetPassword;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'phone_number', 'address', 'activity_status', 'approval_status', 'profile_image', 'license_number',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function services() {
        return $this->hasMany(Service::class);
    }

    public function products() {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function cart() {
        return $this->hasMany(Cart::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'service_provider_id');
    }

}
