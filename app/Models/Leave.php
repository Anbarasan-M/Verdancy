<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'leaves';

    // Define the status constants
    const PENDING = 0;
    const APPROVED = 1;
    const REJECTED = 2;

    protected $fillable = [
        'service_provider_id', 'leave_date', 'reason', 'status'
    ];

    // Relationships
    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }
}
