<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'value'
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

    /**
     * Get the path of Model.
     *
     * @return string
     */
    public function path()
    {
        return '/dashboard/meta-data/';
    }
}
