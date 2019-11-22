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
        factory('App\Model\Applicant')->create(['job_id' => $job, 'status' => 'Reject']);
        factory('App\Model\Applicant')->create(['job_id' => $job, 'status' => 'Waiting']);

        $this->assertEquals('3 Applicants', $job->applicantCountTextOutput());
    }

    /** @test */
    public function jobWillTransformTheApplicantCountWithParam()
    {
        $user = $this->signInEmployer();

        $job = factory('App\Model\Job')->create(['owner_id' => $user->id, 'budget' => ['amount' => '0', 'type' => 'DOE']]);
        factory('App\Model\Applicant')->create(['job_id' => $job]);
        factory('App\Model\Applicant')->create(['job_id' => $job, 'status' => 'Reject']);

        $this->assertEquals('1 Applicant', $job->applicantCountTextOutput('Reject'));
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
