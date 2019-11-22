<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function candidateCanApply()
    {
        $this->withoutExceptionHandling();

        $this->signInEmployee();
        $job = factory('App\Model\Job')->create();

        $create = $this->post($job->jobApplyPath(), $attr = [
            'cover_letter' => 'This is cover Letter'
        ]);

        $create->assertStatus(200)
        ->assertJsonFragment(['success' => 'Application has been sent.']);

        $this->assertDatabaseHas('applicants', $attr);
    }

    /** @test */
    public function candidateWillHaveWaitingStatus()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployee();
        $job = factory('App\Model\Job')->create();

        $create = $this->post($job->jobApplyPath(), $attr = [
            'cover_letter' => 'This is cover Letter'
        ]);

        $create->assertStatus(200)
        ->assertJsonFragment(['success' => 'Application has been sent.']);

        $this->assertDatabaseHas('applicants', [
            'status' => 'Waiting'
        ]);
    }

    /** @test */
    public function candidateCannotApplyTwice()
    {
        $user = $this->signInEmployee();
        $job = factory('App\Model\Job')->create();
        factory('App\Model\Applicant')->create(['job_id' => $job->id, 'user_id' => $user->id]);

        $create = $this->post($job->jobApplyPath(), [
            'user_id' => $user->id,
            'cover_letter' => 'This is cover Letter'
        ]);
        
        $create->assertStatus(403);
    }


    /** @test */
    public function candidateCanHaveMultipleApplicantion()
    {
        $user = $this->signInEmployee();
        $job = factory('App\Model\Job')->create();
        $job2 = factory('App\Model\Job')->create();

        $this->post($job->jobApplyPath(), $attr1 = [
            'user_id' => $user->id,
            'cover_letter' => 'This is cover Letter'
        ]);

        $this->post($job2->jobApplyPath(), $attr2 = [
            'user_id' => $user->id,
            'cover_letter' => 'This is cover Letter'
        ]);
        
        $this->assertDatabaseHas('applicants', $attr1);
        $this->assertDatabaseHas('applicants', $attr2);
    }
}
