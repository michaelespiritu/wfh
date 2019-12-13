<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConversationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ConverstationHasMemberAndMessage()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployee();

        $talent = factory('App\User')->create(['role_id' => 2]);
        factory('App\Model\Profile')->create(['user_id' => $talent->id]);

        $this->post('/conversation', [
            'receiver_id' => $talent->identifier,
            'message' => 'This is a message'
        ]);

        $this->assertDatabaseHas('conversations', [
            'owner_id' => $user->id,
            'read' => null
        ]);

        $this->assertDatabaseHas('messages', [
            'conversation_id' => 1,
            'from_id' => $user->id,
            'message' => 'This is a message',
        ]);

        $this->assertDatabaseHas('conversation_members', [
            'conversation_id' => 1,
            'user_id' => $talent->id
        ]);
    }

    /** @test */
    public function ConverstationWillAppendMessageIfFoundAndWillNotBeAddedToMemberAgain()
    {
        $this->withoutExceptionHandling();

        $sender = $this->signInEmployee();
        
        $conversation = factory('App\Model\Conversation')->create(['owner_id' => $sender->id]);
        factory('App\Model\Conversation')->create(['owner_id' => $sender->id]);

        $conversation->members()->attach( $user = factory('App\User')->create() );

        $create = $this->post('/conversation', [
            'receiver_id' => $user->identifier,
            'message' => 'This is a message'
        ]);

        $this->assertDatabaseHas('conversations', [
            'id' => $conversation->id,
            'identifier' => $conversation->identifier,
            'owner_id' => $sender->id,
            'read' => null
        ]);

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'from_id' => $sender->id,
            'message' => 'This is a message',
        ]);

    }

    /** @test */
    public function conversationCanHaveReplies()
    {
        $this->withoutExceptionHandling();
        
        $user = $this->signInEmployee();

        $conversation = factory('App\Model\Conversation')->create();
        factory('App\Model\Profile')->create(['user_id' => $conversation->owner->id]);
        $conversation->members()->attach( $user );

        $reply = $this->post("{$conversation->path()}/reply", [
            'message' => 'Reply Message',
        ]);

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'from_id' => $user->id,
            'message' => 'Reply Message'
        ]);

        $this->assertDatabaseHas('conversations', [
            'read' => null
        ]);
    }

    /** @test */
    public function conversationCanBeRead()
    {
        $this->withoutExceptionHandling();
        
        $this->signInEmployee();

        $conversation = factory('App\Model\Conversation')->create();
        $message = factory('App\Model\Message')->create(['conversation_id' => $conversation->id]);
        $conversation->update(['unread' => 1]);

        $this->get("{$conversation->path()}/read");

        $this->assertDatabaseHas('conversations', [
            'id' => $message->conversation->id,
            'read' => Carbon::now()
        ]);
    }
}
