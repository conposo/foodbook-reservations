<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reservation_id',
        'guest_order',
        'guest_type',
        'user_id',
        'status',
        'notes',
    ];

    /**
     * Get Menu
     */
    public function menu()
    {
        return $this->hasMany('App\Menu');
    }

}
