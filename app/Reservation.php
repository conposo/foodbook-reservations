<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'restaurant_id',
        'status',
        'creator_id',
        'total_guests',
        'date',
        'time',
        'table',
        'parking',
        'notes',
    ];

    /**
     * Get Guests
     */
    public function guests()
    {
        return $this->hasMany('App\Guest');
    }
    
}
