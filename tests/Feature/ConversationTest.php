<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
            'owner_id' => $user->id
        ]);

        $this->assertDatabaseHas('messages', [
            'conversation_id' => 1,
            'from_id' => $user->id,
            'message' => 'This is a message'
        ]);

        $this->assertDatabaseHas('conversation_members', [
            'conversation_id' => 1,
            'user_id' => $talent->id
        ]);
    }
}
