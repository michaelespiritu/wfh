<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    /** @test */
    public function conversationIsAlwaysReadForLastSender()
    {
        $sender = $this->signInEmployee();
        
        $conversation = factory('App\Model\Conversation')->create(['owner_id' => $sender->id]);

        factory('App\Model\Message')->create(['conversation_id' => $conversation->id, 'from_id' => $sender->id]);

        factory('App\Model\Message')->create(['conversation_id' => $conversation->id, 'from_id' => $sender->id]);


        $this->assertEquals($conversation->wasRead(), true);
    }

    /** @test */
    public function conversationIsConditionalReadForReceiver()
    {
        $sender = factory('App\User')->create();
        
        $conversation = factory('App\Model\Conversation')->create(['owner_id' => $sender->id]);

        factory('App\Model\Message')->create(['conversation_id' => $conversation->id, 'from_id' => $sender->id]);

        $conversation->members()->attach( $user = factory('App\User')->create() );

        $this->actingAs($user);
        
        $this->assertEquals($conversation->wasRead(), false);
    }
}
