<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Resources\ApplicantResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function onlyEmployerCanPostJob()
    {
        $user = $this->signInEmployee();
        
        $create = $this->post('/jobs', $attr = [
            'category_id' => 'IT',
            'title' => 'IT administrator',
            'location' => 'remote', 
            'type' => 'Full Time',
            'budget' => 'DOE', 
            'description' => 'Fuga totam reiciendis qui architecto fugiat nemo.'
        ]);

        $create->assertStatus(403);
    }

    /** @test */
    public function employerCantPostIfCreditIsZero()
    {
        $user = $this->signInEmployer();
        $user->employerCredit->update(['credit' => 0]);
        
        $create = $this->post('/jobs', [
            'category_id' => 1,
            'title' => 'IT administrator',
            'type' => 'Full Time',
            'region_restriction' => 'PH only', 
            'notify_email' => $user->email, 
            'skills' => ['Laravel', 'Angular'], 
            'budget' => ['amount' => '500', 'type' => 'Per Hour'], 
            'description' => 'Fuga totam reiciendis qui architecto fugiat nemo.'
        ]);

        $create->assertStatus(403)
        ->assertJsonFragment([ 'error' => 'You Dont have enough Job Credit.']);
    }

    /** @test */
    public function employerCanAddJobPost()
    {
        $this->withoutExceptionHandling();
        $user = $this->signInEmployer();

        $create = $this->post('/jobs', [
            'category_id' => 1,
            'title' => 'IT administrator',
            'type' => 'Full Time',
            'region_restriction' => 'PH only', 
            'notify_email' => ['test@email.com'], 
            'skills' => ['Laravel', 'Angular'], 
            'budget' => ['amount' => '500', 'type' => 'Per Hour'], 
            'description' => 'Fuga totam reiciendis qui architecto fugiat nemo.'
        ]);

        $create->assertStatus(201)
        ->assertJsonFragment(['success' => 'Job Post has been created.']);

        $this->assertDatabaseHas('job_openings', [
            'category_id' => 1,
            'title' => 'IT administrator',
            'region_restriction' => 'PH only', 
            'notify_email' => json_encode(['test@email.com', $user->email]), 
            'type' => 'Full Time',
            'skills' => json_encode(['Laravel', 'Angular']), 
            'budget' => json_encode(['amount' => '500', 'type' => 'Per Hour']), 
            'description' => 'Fuga totam reiciendis qui architecto fugiat nemo.'
        ]);

        $this->assertDatabaseHas('employer_credits', ['credit' => 0]);
    }


    /** @test */
    public function employerCanUpdateJobPost()
    {
        $this->withoutExceptionHandling();
        $user = $this->signInEmployer();

        $job = factory('App\Model\Job')->create(['owner_id' => $user->id]);

        $update = $this->patch($job->path(), [
            'category_id' => 1,
            'title' => 'IT administrator',
            'region_restriction' => 'EU only', 
            'notify_email' => $job->notify_email, 
            'type' => $job->type,
            'skills' => ['Laravel', 'Angular'], 
            'budget' => ['amount' => '500', 'type' => 'Per Hour'],   
            'description' => $job->description
        ]);

        $update->assertStatus(200)
        ->assertJsonFragment(['success' => 'Job Post has been updated.']);

        $this->assertDatabaseHas('job_openings', [
            'category_id' => 1,
            'title' => 'IT administrator',
            'region_restriction' => 'EU only', 
            'notify_email' => json_encode($job->notify_email), 
            'type' => $job->type,
            'skills' => json_encode(['Laravel', 'Angular']), 
            'budget' => json_encode(['amount' => '500', 'type' => 'Per Hour']),   
            'description' => $job->description
        ]);
    }

    /** @test */
    public function employerCanDeleteJobPost()
    {
        $this->withoutExceptionHandling();
        $user = $this->signInEmployer();
        
        $job = factory('App\Model\Job')->create(['owner_id' => $user->id]);

        $delete = $this->delete($job->path());

        $delete->assertStatus(200)
        ->assertJsonFragment(['success' => 'Job Post has been deleted.']);

        $this->assertDatabaseMissing('job_openings', ['id' => $job->id]);
    }

    /** @test */
    public function employerCanUpdateStatusOfApplicant()
    {
        $employer = $this->signInEmployer();

        $employee = factory('App\User')->create(['role_id' => 2]);
        factory('App\Model\Profile')->create(['user_id' => $employee->id]);

        $job = factory('App\Model\Job')->create(['owner_id' => $employer->id]);
        $applicant = factory('App\Model\Applicant')->create(['job_id' => $job->id, 'user_id' => $employee->id]);

        $update = $this->post("/application/$applicant->identifier/update-status", [
            'status' => 'Rejected'
        ]);
        
        $update->assertStatus(200)
            ->assertJsonFragment([ 'success' => 'Applicant Status has been Updated.']);

        $this->assertDatabaseHas('applicants', [
            'identifier' => $applicant->identifier,
            'status' => 'Rejected'
        ]);
    }

    /** @test */
    public function jobCanHaveMultipleApplications()
    {
        $user = $this->signInEmployee();
        $existing = factory('App\User')->create(['role_id' => 2]);
        $job = factory('App\Model\Job')->create();
        factory('App\Model\Applicant')->create(['job_id' => $job->id, 'user_id' => $existing->id]);

        $create = $this->post($job->jobApplyPath(), $attr = [
            'user_id' => $user->id,
            'cover_letter' => 'This is cover Letter'
        ]);
        
        $create->assertStatus(200)
        ->assertJsonFragment([ 'success' => 'Application has been sent.']);

        $this->assertDatabaseHas('applicants', $attr);
    }
}
