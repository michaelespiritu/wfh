<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function jobHasRemainingDaysDisplay()
    {
        $user = $this->signInEmployer();

        $job = factory('App\Model\Job')->create(['owner_id' => $user->id]);

        $this->assertEquals('60 Days', $job->daysRemaining());
    }

    /** @test */
    public function jobHasNoRemainingDaysDisplay()
    {
        $user = $this->signInEmployer();

        $job = factory('App\Model\Job')->create(['owner_id' => $user->id, 'expiration' => '2019-11-03 16:53:55']);

        $this->assertEquals('Job Expired.', $job->daysRemaining());
    }

    /** @test */
    public function jobBudgetDisplayIfWithAmount()
    {
        $user = $this->signInEmployer();

        $job = factory('App\Model\Job')->create(['owner_id' => $user->id]);

        $this->assertEquals('$500 Per Hour', $job->allotedBudget());
    }

    /** @test */
    public function jobBudgetDisplayIfWithNoAmount()
    {
        $user = $this->signInEmployer();

        $job = factory('App\Model\Job')->create(['owner_id' => $user->id, 'budget' => ['amount' => '0', 'type' => 'DOE']]);

        $this->assertEquals('DOE', $job->allotedBudget());
    }

    /** @test */
    public function jobWillTransformTheApplicantCount()
    {
        $user = $this->signInEmployer();

        $job = factory('App\Model\Job')->create(['owner_id' => $user->id, 'budget' => ['amount' => '0', 'type' => 'DOE']]);

        factory('App\Model\Applicant')->create(['job_id' => $job]);
        factory('App\Model\Applicant')->create(['job_id' => $job]);
        factory('App\Model\Applicant')->create(['job_id' => $job]);

        $this->assertEquals('3 Applicants', $job->applicantCountTextOutput());
    }

    /** @test */
    public function jobWillTransformTheApplicantCountWithParam()
    {
        $this->withoutExceptionHandling();
        $user = $this->signInEmployer();

        $job = factory('App\Model\Job')->create(['owner_id' => $user->id, 'budget' => ['amount' => '0', 'type' => 'DOE']]);
        
        factory('App\Model\JobBoard')->create(['job_id' => $job->id, 'name' => 'Waiting']);
        $reject = factory('App\Model\JobBoard')->create(['job_id' => $job->id, 'name' => 'Rejected']);

        factory('App\Model\Applicant')->create(['job_id' => $job]);
        factory('App\Model\Applicant')->create(['job_id' => $job, 'status_id' => $reject->id]);
        
        $this->assertEquals('1 Applicant', $job->applicantCountTextOutput($reject->identifier));
    }

    /** @test */
    public function jobHasPath()
    {
        $user = $this->signInEmployer();
        $job = factory('App\Model\Job')->create(['owner_id' => $user->id]);

        $this->assertEquals($job->path(), "/jobs/$job->identifier");
    }

    /** @test */
    public function jobHasApplyPath()
    {
        $user = $this->signInEmployer();
        $job = factory('App\Model\Job')->create(['owner_id' => $user->id]);

        $this->assertEquals($job->jobApplyPath(), "/app/jobs/apply/$job->identifier");
    }
}
