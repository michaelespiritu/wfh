<?php

namespace App\Traits;

use App\Traits\UserTrait;
use Illuminate\Support\Str;

trait MessagesTrait
{
    use UserTrait;
    
    /**
     * The Logic to Send Message
     *
     * @param  $user $data
     * @return object
     */
    public function createMessage($user, $data)
    {
        $receiver = $this->findUser($data['receiver_id']);

        $data['identifier'] = Str::uuid();
        $data['receiver_id'] =  $receiver->id;

        return $user->messages()->create($data);

    }

}