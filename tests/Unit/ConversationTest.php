<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConversationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function conversationLastestMessage()
    {
        $converstion = factory('App\Model\Conversation')->create();
        factory('App\Model\Message')->create(['conversation_id' => $converstion->id, 'from_id' => $converstion->owner_id]);
        $message = factory('App\Model\Message')->create(['conversation_id' => $converstion->id, 'from_id' => $converstion->owner_id]);

        $this->assertEquals($converstion->latestMessage()->message, $message->message);
    }

    /** @test */
    public function conversationLastestMember()
    {
        $conversation = factory('App\Model\Conversation')->create();

        $conversation->members()->attach( factory('App\User')->create() );
        $conversation->members()->attach( $user = factory('App\User')->create() );

        $this->assertEquals($conversation->latestMember()->id, $user->id);
    }
}
