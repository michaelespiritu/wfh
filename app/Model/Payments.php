<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'user_id', 'purchase_id', 'amount'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'identifier';
    }
}
