<?php

namespace App\Traits;

use Illuminate\Support\Str;
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
     * Create the User in Stripe and Save details in Database
     *
     * @return object
     */
    public function updateCustomerInStripe($user, $data = [])
    {
        Stripe::customers()->update($user->stripe_id, $data);

        return;
    }

    /**
     * Create the Card of User in Stripe to be used for purchase
     *
     * @return bool
     */
    public function createCardForUser($user, $token)
    {
        $card = Stripe::cards()->create($user->stripe_id, $token);

        $this->updateCustomerInStripe(
            $user, 
            [
                'default_source' => $card['id'],
            ]
        );
       
        $user->update([
            'card_last_four' => $card['last4'], 
            'card_brand' => $card['brand']
        ]);

        return;
    }

    /**
     * Determine if the user has a card stored in Stripe
     *
     * @return object
     */
    public function determineIfhasACard($user, $token)
    {
        $card = Stripe::cards()->all($user->stripe_id);

        if (!$card['data'])
            $card = $this->createCardForUser($user, $token);

        return;
    }

    /**
     * Screening before charging the User in Stripe
     *
     */
    public function createPaymentScreen ($user, $token, $editCard)
    {
        if (!$user->stripe_id) {
            $this->createCustomerInStripe($user);

            $this->createCardForUser($user, $token);

            return;
        }

        $this->determineIfhasACard($user, $token);

        if ($editCard)
            $this->createCardForUser($user, $token);

        return;
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

        $this->createPaymentScreen($user, request()->token['id'], request()->editCard);
        
        try {
            $charge = Stripe::charges()->create([
                'customer' => $user->stripe_id,
                'currency' => 'USD',
                'amount'   => $amount,
            ]);
            
            $user->payments()->create([
                'identifier' => Str::uuid(),
                'purchase_id' => $charge['id'],
                'amount' => $amount
            ]);

            $pass = [
                'pass' => true,
                'message' => $charge
            ];
        } catch(Stripe_CardError $e) {
            $pass = [
                'pass' => false,
                'message' => $e->getMessage().'Stripe_CardError'
            ];
        } catch (Stripe_InvalidRequestError $e) {
            // Invalid parameters were supplied to Stripe's API
            $pass = [
                'pass' => false,
                'message' => $e->getMessage().'Stripe_InvalidRequestError'
            ];
        } catch (Stripe_AuthenticationError $e) {
            // Authentication with Stripe's API failed
            $pass = [
                'pass' => false,
                'message' => $e->getMessage().'Stripe_AuthenticationError'
            ];
        } catch (Stripe_ApiConnectionError $e) {
            // Network communication with Stripe failed
            $pass = [
                'pass' => false,
                'message' => $e->getMessage().'Stripe_ApiConnectionError'
            ];
        } catch (Stripe_Error $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $pass = [
                'pass' => false,
                'message' => $e->getMessage().'Stripe_Error'
            ];
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $pass = [
                'pass' => false,
                'message' => 'Something went wrong.'
            ];
        }
        
        return $pass;
    }

}    