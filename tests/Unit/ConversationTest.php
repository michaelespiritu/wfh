<?php

namespace Tests\Unit;

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

    /** @test */
    public function ConversationCanDetermineIfTheReceiverIsAlreadyAMember()
    {
        $sender = $this->signInEmployee();
        
        $conversation = factory('App\Model\Conversation')->create(['owner_id' => $sender->id]);
        $conversation2 = factory('App\Model\Conversation')->create(['owner_id' => $sender->id]);

        factory('App\Model\Message')->create(['conversation_id' => $conversation->id, 'from_id' => $sender->id]);

        $conversation->members()->attach( $user = factory('App\User')->create() );

        $this->assertJson($conversation, $sender->isConversationMember($user->identifier));
    }

    /** @test */
    public function ConversationCanDetermineIfTheReceiverIsNotAMember()
    {
        $sender = $this->signInEmployee();
        
        $conversation = factory('App\Model\Conversation')->create(['owner_id' => $sender->id]);
        $conversation2 = factory('App\Model\Conversation')->create(['owner_id' => $sender->id]);

        factory('App\Model\Message')->create(['conversation_id' => $conversation->id, 'from_id' => $sender->id]);

        $user = factory('App\User')->create();

        $this->assertEquals($sender->isConversationMember($user->identifier), null);
    }

    /** @test */
    public function OutputNumberOfUnreadConverationIfSender()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployer();

        $conversation = factory('App\Model\Conversation')->create(['owner_id' => $user->id]);

        $message = factory('App\Model\Message')->create(['conversation_id' => $conversation->id, 'from_id' => $user->id]);

        $this->assertEquals($user->unread_messages, 0);
    }

    /** @test */
    public function OutputNumberOfUnreadConverationIfReceiver()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();

        $conversation = factory('App\Model\Conversation')->create(['owner_id' => $user->id]);

        factory('App\Model\Message')->create(['conversation_id' => $conversation->id, 'from_id' => $user->id]);

        $conversation->members()->attach( $receiver = factory('App\User')->create() );

        $this->actingAs( $receiver );

        $this->assertEquals($receiver->unread_messages, 1);
    }
}
