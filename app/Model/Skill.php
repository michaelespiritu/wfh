<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'skill'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'skill' => 'json',
    ];

    /**
     * The User of Skill
     * 
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the path of Model.
     *
     * @return string
     */
    public function path()
    {
        return "/skills/{$this->id}";
    }
}
