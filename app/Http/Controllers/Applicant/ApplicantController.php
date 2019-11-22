<?php

namespace App\Http\Controllers\Applicant;

use App\Model\Job;
use App\Model\Applicant;
use App\Traits\JobsTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;

class ApplicantController extends Controller
{
    use JobsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = ApplicationResource::collection(auth()->user()->applications);
        return view('application.all')->with('applications', $applications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Job $job)
    {
        $this->authorize('apply', $job);

        $this->applyForJob($job, $request->all());

        return response()->json([
            'success' => 'Application has been sent.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Model\Applicant $application
     * @return \Illuminate\Http\Response
     */
    public function show(Applicant $application)
    {
        return view('application.view')->with('application', $application);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
