<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicantTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function applicantIsUserInstance()
    {
        $user = $this->signInEmployee();
        $job = factory('App\Model\Job')->create();
        $applicant = factory('App\Model\Applicant')->create(['job_id' => $job->id, 'user_id' => $user->id]);

        $this->assertInstanceOf(\App\User::class, $applicant->user);
    }
}
