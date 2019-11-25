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
        return Stripe::cards()->create($user, $token);
    }

    /**
     * Determine if the user has a card stored in Stripe
     *
     * @return object
     */
    public function determineIfhasACard($user, $token)
    {
        $card = Stripe::cards()->all($user);

        if (!$card['data'])
            $this->createCardForUser($user, $token);

    }

    /**
     * Screening before charging the User in Stripe
     *
     * @return bool
     */
    public function createPaymentScreen ($user, $token)
    {
        if (!$user->stripe_id) {
            $this->createCustomerInStripe($user);

            $this->createCardForUser($user->stripe_id, $token);

            return;
        }

        return $this->determineIfhasACard($user->stripe_id, $token);
    }

    /**
     * Charge User in Stripe
     *
     * @return bool
     */
    public function createPayment($user, $amount)
    {
        $pass =  [
            'pass' => false,
            'message' => 'Something went wrong.'
        ];

        $this->createPaymentScreen($user, request()->token['id']);
        
        try {
            $charge = Stripe::charges()->create([
                'customer' => $user->stripe_id,
                'currency' => 'USD',
                'amount'   => $amount,
            ]);
            
            $pass = [
                'pass' => true,
                'message' => $charge
            ];
        } catch(Stripe_CardError $e) {
            $pass = [
                'pass' => false,
                'message' => $e->getMessage()
            ];
        } catch (Stripe_InvalidRequestError $e) {
            // Invalid parameters were supplied to Stripe's API
            $pass = [
                'pass' => false,
                'message' => $e->getMessage()
            ];
        } catch (Stripe_AuthenticationError $e) {
            // Authentication with Stripe's API failed
            $pass = [
                'pass' => false,
                'message' => $e->getMessage()
            ];
        } catch (Stripe_ApiConnectionError $e) {
            // Network communication with Stripe failed
            $pass = [
                'pass' => false,
                'message' => $e->getMessage()
            ];
        } catch (Stripe_Error $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $pass = [
                'pass' => false,
                'message' => $e->getMessage()
            ];
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $pass = [
                'pass' => false,
                'message' => $e->getMessage()
            ];
        }
        
        return $pass;
    }

}    