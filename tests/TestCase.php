<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function userRole ()
    {
        factory('App\Model\Role')->create(['name' => 'employer']);
        factory('App\Model\Role')->create(['name' => 'employee']);
        factory('App\Model\Category')->create();
    }

    protected function signInEmployer($user = null)
    {
        $this->userRole();
        $user = $user ?: factory('App\User')->create(['role_id' => 1]);
        factory('App\Model\EmployerCredit')->create(['user_id' => 1]);
        factory('App\Model\Profile')->create(['user_id' => $user->id]);
        $this->actingAs($user);
        return $user;
    }

    protected function signInEmployee($user = null)
    {
        $this->userRole();
        $user = $user ?: factory('App\User')->create(['role_id' => 2]);
        factory('App\Model\Profile')->create(['user_id' => $user->id]);
        $this->actingAs($user);
        return $user;
    }
}
