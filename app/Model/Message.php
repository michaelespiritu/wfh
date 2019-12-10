<?php

namespace App\Model;

use App\User;
use App\Model\Conversation;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'conversation_id', 'from_id', 'message'
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

    /**
     * The Conversation of Message
     * 
     * @return bool
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the path of Model.
     *
     * @return string
     */
    public function path()
    {
        return "/message/$this->identifier";
    }

}
