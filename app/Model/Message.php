<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'conversation_id', 'from_id', 'message', 'read'
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
     * Get the User Model of Sender.
     *
     * @return App\User
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

}
