<?php

namespace App\Traits;

use App\User;
use Illuminate\Support\Str;

trait UserTrait
{
    /**
     * Find User via identifier
     * 
     * @return object
     * @param $identifier
     */
    public function findUser($identifier)
    {
        return User::whereIdentifier($identifier)->firstOrFail();
    }

    /**
     * Create Credit for Employer to be used in Job Posting
     * 
     * @return $meta
     * @param $user
     */
    public function createCredit($user)
    {
        if ($user->role->id == 1) {
            $user->employerCredit()->create(['credit' => 1]);
        }
    }

    /**
     * Create Meta For Users
     * 
     * @return $meta
     * @param $user
     */
    public function createMeta($user)
    {
        if ($user->role->id == 1) {
            $user->userMeta()->create(['name' => 'company_name']);
            $user->userMeta()->create(['name' => 'company_url']);
            $user->userMeta()->create(['name' => 'company_description']);
            $user->userMeta()->create(['name' => 'company_logo']);
            $user->userMeta()->create(['name' => 'company_hq']);
        }
    }

    /**
     * Update or Create Profile For User
     * 
     * @return $profile
     * @param $user, $data
     */
    public function userProfile($user, $data)
    {
        return $profile = $user->profile()->updateOrCreate(
            [
                'user_id' => $user->id
            ], 
            $data
        );
    }


    /**
     * Create Meta Data For User
     * 
     * @return $meta
     * @param $user, $data
     */
    public function createUserMeta($user, $data)
    {
        return $user->userMeta()->updateOrCreate(
            [
                'user_id' => $user->id,
                'name' => $data['name']
            ], 
            [
                'value' => $data['value']
            ]
        );
    }


    /**
     * Update Meta Data For User
     * 
     * @return $meta
     * @param $user, $data
     */
    public function updateUserMeta($meta, $data)
    {
        return $meta->update($data);
    }

}