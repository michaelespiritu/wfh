<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'profile_image', 'timezone'
    ];

    /**
     * The attributes that should be mutated to json.
     *
     * @var array
     */
    protected $casts = [
        'timezone' => 'json'
    ];

    /**
     * Get the path of Model.
     *
     * @return string
     */
    public function path()
    {
        return '/profile/';
    }
}
