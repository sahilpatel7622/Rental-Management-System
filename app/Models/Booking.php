<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    protected $fillable = [
        'user_id',
        'property_id',
        'check_in',
        'check_out',
        'total_days',
        'total_amount',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

}