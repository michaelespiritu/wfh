<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Traits\UserTrait;
use Illuminate\Support\Str;

trait MessagesTrait
{
    use UserTrait;

    /**
     * The Logic to Start Conversation
     *
     * @param  $user $data
     * @return object
     */
    public function startConversation($user, $data)
    {
        if ( $conversation = $user->isConversationMember( $data['receiver_id'] ) ) {
            return $conversation;
        } else {
            $data['identifier'] = Str::uuid();
            return $user->conversations()->create($data);
        }
    }

    /**
     * The Logic to Create Message for Conversation
     *
     * @param  $user $data
     * @return object
     */
    public function updateConversation($conversation, $data)
    {
        $conversation->update($data);
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

        $this->updateConversation($conversation, ['read' => null]);
    }

    /**
     * Mark the conversation as Read
     *
     * @param  $user $data
     * @return object
     */
    public function markAsRead($conversation)
    {
        if ( !$conversation->wasRead() ) {
            $conversation->update([
                'read' => Carbon::now()
            ]);
        }
    
    }

    /**
     * The Logic to Create Message for Conversation
     *
     * @param  $user $data
     * @return object
     */
    public function attachMembersToConversation($conversation, $member)
    {
        $user = $this->findUser($member);

        if (!$conversation->isMember($user)) {
            $conversation->members()->attach( $user );
        }
    }

}