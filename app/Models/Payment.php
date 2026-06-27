<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $fillable = [
        'booking_id',
        'user_id',
        'amount',
        'payment_method',
        'payment_status',
    ];

    // Payment belongs to Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Payment belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}