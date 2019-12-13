<?php

namespace App\Model;

use App\User;
use App\Model\Message;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'owner_id', 'read', 'lastest_message'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'read' => 'datetime',
    ];

    /**
     * The Owner of Conversation
     * 
     * @return App\Model\Message
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * The Message History of Conversation
     * 
     * @return App\Model\Message
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * The Members of Conversation
     * 
     * @return App\Model\Message
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'conversation_members')->withTimestamps();
    }

    /**
     * The Conversation Latest Message
     * 
     * @return App\Model\Message
     */
    public function latestMessage()
    {
        return $this->messages->last();
    }

    /**
     * The Conversation Latest Member
     * 
     * @return App\Model\Message
     */
    public function latestMember()
    {
        return $this->members->last();
    }

    /**
     * Determine if the conversation was read or not.
     * 
     * @return bool
     */
    public function wasRead()
    {
        if (auth()->user()->id == $this->latestMessage()->from_id) {
            return true;
        } else {
            return (!empty($this->read)) ? true : false;
        }
    }

    /**
     * Determine if the User is already part of conversation.
     * 
     * @return bool
     */
    public function isMember($user)
    {
        return $this->members->contains($user);
    }

    /**
     * Get the path of Model.
     *
     * @return string
     */
    public function path()
    {
        return "/conversation/$this->identifier";
    }
}
