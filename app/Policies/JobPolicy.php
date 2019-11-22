<?php

namespace App\Policies;

use App\Model\Job;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any jobs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isEmployer();
    }

    /**
     * Determine whether the user is employee or employer
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewEmployee(User $user)
    {
        return !$user->isEmployer();
    }

    /**
     * Determine whether the user can view the job.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Job  $job
     * @return mixed
     */
    public function view(User $user, Job $job)
    {
        //
    }

    /**
     * Determine whether the user can create jobs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the job.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Job  $job
     * @return mixed
     */
    public function update(User $user, Job $job)
    {
        return $user->is($job->owner);
    }

    /**
     * Determine whether the user can delete the job.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Job  $job
     * @return mixed
     */
    public function delete(User $user, Job $job)
    {
        return $user->is($job->owner);
    }

    /**
     * Determine whether the user can restore the job.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Job  $job
     * @return mixed
     */
    public function restore(User $user, Job $job)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the job.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Job  $job
     * @return mixed
     */
    public function forceDelete(User $user, Job $job)
    {
        //
    }


    /**
     * Determine whether the user can permanently delete the job.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Job  $job
     * @return mixed
     */
    public function apply(User $user, Job $job)
    {
        return !$job->applicants->contains('user_id', $user->id)
                ? Response::allow()
                : Response::deny('You already applied for this Job.');
    }

}
