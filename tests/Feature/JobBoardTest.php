<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobBoardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function JobCanAddJobBoard()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployer();
        $job = factory('App\Model\Job')->create(['owner_id' => $user->id]);
        factory('App\Model\JobBoard')->create(['job_id' => $job->id, 'name' => 'Shortlisted']);
        factory('App\Model\JobBoard')->create(['job_id' => $job->id, 'name' => 'Waiting']);
        factory('App\Model\JobBoard')->create(['job_id' => $job->id, 'name' => 'Rejected']);

        $this->post($job->path(). "/create/job-board", [
            'name' => 'Interwviewing'
        ])->assertJsonFragment([
            'success' => 'Board has been Created.'
        ]);

        $this->assertDatabaseHas('job_boards', [
            'job_id' => $job->id,
            'name' => 'Interwviewing'
        ]);

    }
}
