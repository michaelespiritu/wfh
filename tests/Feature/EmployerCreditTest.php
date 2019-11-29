<?php

namespace Tests\Feature;

use Carbon\Carbon;
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

        $token = null;

        Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");

        $token = Stripe::tokens()->create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 1,
                "exp_year" => 2020,
                "cvc" => "314"
            )
        ));
        
        $buy = $this->post('/credit/buy-credit', [
            'target' => null,
            'editCard' => false,
            'credit' => 2,
            'token' => $token
        ]);

        $this->assertDatabaseHas('users', [
            'card_last_four' => '4242',
            'card_brand' => 'Visa'
        ]);

        $this->assertDatabaseHas('employer_credits', [
            'user_id' => $user->id,
            'credit' => 2
        ]);

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'amount' => 10
        ]);


        $this->assertEquals($user->employerCredit->fresh()->credit, 2);
    }

    /** @test */
    public function EmployerCanBuyJobCreditsAndWillActivateTheLastJobRequest()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployer();

        $job = factory('App\Model\Job')->create(['owner_id' => $user->id, 'expiration' => null]);

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
            'target' => $job->identifier,
            'editCard' => false,
            'credit' => 3,
            'token' => $token
        ]);


        $this->assertDatabaseHas('job_openings', [
            'identifier' => $job->identifier,
            'expiration' => Carbon::now()->addDays(60)
        ]);

        $this->assertEquals($user->employerCredit->fresh()->credit, 2);
    }

    /** @test */
    public function EmployerCreditsWillAddUp()
    {
        $this->withoutExceptionHandling();
        $user = $this->signInEmployer();

        $user->employerCredit()->update(['credit' => 5]);

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
            'editCard' => false,
            'credit' => 2,
            'token' => $token
        ]);

        $this->assertDatabaseHas('employer_credits', [
            'user_id' => $user->id,
            'credit' => 7
        ]);

        $this->assertEquals($user->employerCredit->fresh()->credit, 7);
    }


    /** @test */
    public function EmployerCanSeeErrorInPaymentDetails()
    {
        $user = $this->signInEmployer();

        $user->employerCredit()->update(['credit' => 0]);

        Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");

        $token = Stripe::tokens()->create(array(
            "card" => array(
                "number" => "4000000000000341",
                "exp_month" => 1,
                "exp_year" => 2020,
                "cvc" => "314"
            )
        ));
        
        $buy = $this->post('/credit/buy-credit', [
            'editCard' => false,
            'credit' => 2,
            'token' => $token
        ]);

        $buy->assertStatus(500);
    }

}
