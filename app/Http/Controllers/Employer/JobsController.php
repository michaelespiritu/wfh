<?php

namespace App\Http\Controllers\Employer;

use App\Model\Job;
use App\Traits\JobsTrait;
use Illuminate\Http\Request;
use App\Http\Requests\JobValidator;
use App\Http\Resources\JobResource;
use App\Http\Controllers\Controller;

class JobsController extends Controller
{
    use JobsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Job::class);

        return view('jobs.all');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('viewAny', Job::class);
        
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\JobValidator  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobValidator $request)
    {
        $job = $this->createJob(auth()->user(), $request->all());

        if (!$this->checkIfCreditIsNotZero()) {

            $job->update(['expiration' => null]);

            return response()->json([
                'success' => 'You Dont have enough Job Credit.',
                'job' => $job
            ], 201);
        }

        return response()->json([
            'success' => 'Job Post has been created.',
            'job' => $job
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  App\Model\Job $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        $this->authorize('viewAny', Job::class);

        return view('jobs.view')->with('job', JobResource::make($job));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  App\Model\Job $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        $this->authorize('update', $job);

        return view('jobs.edit')->with('job',  JobResource::make($job));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\JobValidator  $request
     * @param  int  App\Model\Job $job
     * @return \Illuminate\Http\Response
     */
    public function update(JobValidator $request, Job $job)
    {
        $this->authorize('update', $job);
        $this->updateJob($job, $request->all());

        return response()->json([
            'success' => 'Job Post has been updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  App\Model\Job $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        $this->deleteJob($job);

        return response()->json([
            'success' => 'Job Post has been deleted.'
        ]);
    }

}
