<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function employerCanMessageTalen()
    {
        $this->withoutExceptionHandling();
    
        $user = $this->signInEmployee();

        $talent = factory('App\User')->create(['role_id' => 2]);
        factory('App\Model\Profile')->create(['user_id' => $talent->id]);

        $create = $this->post('/message', [
            'message' => 'This is a message',
            'receiver_id' => $talent->identifier
        ]);

        $create->assertStatus(200)
                ->assertJsonFragment([
                    'success' => 'Message has been sent.'
                ]);

        $this->assertDatabaseHas('messages',[
            'message' => 'This is a message',
            'receiver_id' => $talent->id,
            'sender_id' => $user->id,
            'reply_to' => 0,
            'read' => null
        ]);
    }
}