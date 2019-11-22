<?php

namespace Tests\Feature;

use Tests\TestCase;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployerCreditTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function EmployerCanBuyJobCredits()
    {
        $this->withoutExceptionHandling();
        $user = $this->signInEmployer();

        $user->employerCredit()->update(['credit' => 0]);

        Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");

        $token = Stripe::tokens()->create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 1,
                "exp_year" => 2020,
                "cvc" => "314"
            )
        ));
        
        $this->post('/credit/buy-credit', [
            'credit' => 2,
            'token' => $token
        ]);

        $this->assertDatabaseHas('employer_credits', [
            'user_id' => $user->id,
            'credit' => 2
        ]);

        $this->assertEquals($user->employerCredit->credit, 2);
    }
}
