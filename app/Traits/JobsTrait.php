<?php

namespace App\Traits;

use App\Model\Job;
use Carbon\Carbon;
use Illuminate\Support\Str;

trait JobsTrait
{
    /**
     * The Check if credit is Zero or not
     *
     * @return bool
     */
    public function checkIfCreditIsNotZero()
    {
        return (empty(auth()->user()->employerCredit->credit)) ? false : true;
    }

    /**
     * Find the value of corresponding identifier
     *
     * @return App\Model\Job Object
     */
    public function findJob($identifier)
    {
        return Job::whereIdentifier($identifier)->first();
    }

    /**
     * The Logic to create Job Post
     *
     * @param  $user $data
     * @return object
     */
    public function createJob($user, $data)
    {
        $data['identifier'] = Str::uuid();
        $data['expiration'] = Carbon::now()->addDays(60);
        
        array_push( $data['notify_email'], auth()->user()->email);

        $job = $user->jobs()->create($data);

        $this->lessJobCredit($user);

        return $job;
    }

    /**
     * The Logic less Job Credit when Job is Posted
     *
     * @param  $user
     * @return int
     */
    private function lessJobCredit($user)
    {
        $user->employerCredit()->update(['credit' => $user->minusEmployerCredit()]);
    }

    /**
     * The Logic Update Job Post
     *
     * @param  $job $data
     * @return object
     */
    public function updateJob($job, $data)
    {
        return $job->update($data);
    }

    /**
     * The Logic Update Job Expiration Only
     *
     * @param  $job $data
     * @return object
     */
    public function updateJobExpiration($job)
    {
        return $job->update(['expiration' => Carbon::now()->addDays(60)]);
    }

    /**
     * The Logic Delete Job Post
     *
     * @param  $job
     * @return object
     */
    public function deleteJob($job)
    {
        return $job->delete();
    }

    /**
     * The Logic to Apply for Job Post
     *
     * @param  $job $data
     * @return object
     */
    public function applyForJob($job, $data)
    {
        $data['identifier'] = Str::uuid();
        $data['user_id'] = auth()->user()->id;
        return $job->applicants()->create($data);
    }

    /**
     * The Logic to Apply for Job Post
     *
     * @param  $job $data
     * @return object
     */
    public function checkForTargetToBeUpdate($target, $user)
    {
        if (!empty($target)) {
            $this->updateJobExpiration($this->findJob($target));
            $this->lessJobCredit($user);

            return;
        }

        return;
    }
}