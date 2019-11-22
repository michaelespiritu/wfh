<?php

namespace App\Traits;

trait CreditsTrait
{

    /**
     * Update the Job Credit
     *
     * @return bool
     */
    public function buyCredits($user, $request)
    {
        return $user->employerCredit()->update([
            'credit' => $request['credit']
        ]);
    }

}