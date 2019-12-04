<?php

namespace App\Traits;

use App\Traits\UserTrait;
use Illuminate\Support\Str;

trait MessagesTrait
{
    use UserTrait;
    
    /**
     * The Logic to Send Message
     *
     * @param  $user $data
     * @return object
     */
    // public function createMessage($user, $data)
    // {
    //     $receiver = $this->findUser($data['receiver_id']);

    //     $data['identifier'] = Str::uuid();
    //     $data['receiver_id'] =  $receiver->id;

    //     return $user->messagesSender()->create($data);
    // }

    /**
     * The Logic to Start Conversation
     *
     * @param  $user $data
     * @return object
     */
    public function startConversation($user, $data)
    {
        $data['identifier'] = Str::uuid();
        return $user->conversations()->create($data);
    }

    /**
     * The Logic to Create Message for Conversation
     *
     * @param  $user $data
     * @return object
     */
    public function createMessage($conversation, $message, $from)
    {
        $conversation->messages()->create([
            'identifier' => Str::uuid(),
            'message' => $message,
            'from_id' => $from
        ]);
    }

    /**
     * The Logic to Create Message for Conversation
     *
     * @param  $user $data
     * @return object
     */
    public function attachMembersToConversation($conversation, $member)
    {
        $conversation->members()->attach( $this->findUser($member) );
    }

}