<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'property';
    protected $fillable = [
        'title',
        'slug',
        'location',
        'rent_price',
        'image',
        'description',
        'status'
    ];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

}
