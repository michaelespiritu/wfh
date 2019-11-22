<?php

namespace App\Http\Controllers\Employer;

use App\Model\Job;
use App\Model\Applicant;
use Illuminate\Http\Request;
use App\Traits\ApplicantsTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicantResource;

class ApplicantController extends Controller
{
    use ApplicantsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage(Job $job)
    {
        $this->authorize('viewAny', Job::class);
        
        $waiting = $job->applicants->where('status', '=', 'Waiting');
        $reject = $job->applicants->where('status', '=', 'Reject');
        $shortlist = $job->applicants->where('status', '=', 'Shortlist');

        return view('jobs.manage-applicants')
            ->with('waiting', ApplicantResource::collection($waiting))
            ->with('reject', ApplicantResource::collection($reject))
            ->with('shortlist', ApplicantResource::collection($shortlist))
            ->with('job', $job);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Job $job)
    {
        $this->authorize('viewAny', Job::class);
        
        $applicants = $job->applicants;

        $type = 'all';

        if ( isset($_GET['type']) ) {
            $applicants = $job->applicants->where('status', '=', $_GET['type']);
            $type = $_GET['type'];
        }


        return view('jobs.applicants')
            ->with('applicants', ApplicantResource::collection($applicants))
            ->with('job', $job)
            ->with('type', $type);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Applicant $applicant)
    {
        $this->updateApplicantStatus($applicant, request()->all());

        $applicants = $applicant->job->applicants;

        if ( request()->type != 'all' ) {
            $applicants = $applicant->job->applicants->where('status', '=', request()->type);
        }

        return response()->json([
            'success' => 'Applicant Status has been Updated.',
            'applicants' => ApplicantResource::collection($applicants->fresh())
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
