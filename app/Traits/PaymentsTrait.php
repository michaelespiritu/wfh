<?php

namespace App\Traits;

use Cartalyst\Stripe\Laravel\Facades\Stripe;

trait PaymentsTrait
{
    /**
     * Create the User in Stripe and Save details in Database
     *
     * @return object
     */
    public function createCustomerInStripe($user)
    {
        $create = Stripe::customers()->create(
            [
                'name' => $user->name,
                'email' => $user->email
            ]
        );

        $user->update(['stripe_id' => $create['id']]);

        return $create;
    }

    /**
     * Create the Card of User in Stripe to be used for purchase
     *
     * @return bool
     */
    public function createCardForUser($user, $token)
    {
        return Stripe::cards()->create($user->stripe_id, $token);
    }

    /**
     * Charge User in Stripe
     *
     * @return bool
     */
    public function createPayment($user, $amount)
    {
        if (!$user->stripe_id) {
            $this->createCustomerInStripe($user);

            $this->createCardForUser($user, request()->token['id']);
        }
 
 
        Stripe::charges()->create([
            'customer' => $user->stripe_id,
            'currency' => 'USD',
            'amount'   => $amount,
        ]);
    }
}    