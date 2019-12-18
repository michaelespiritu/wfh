<?php

namespace App\Http\Controllers\Employer;

use App\Model\Job;
use App\Model\Applicant;
use Illuminate\Http\Request;
use App\Traits\ApplicantsTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicantResource;
use App\Http\Resources\JobBoardResource;
use App\Model\JobBoard;

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

        return view('jobs.manage-applicants')
            ->with('boards', JobBoardResource::collection($job->jobBoards))
            ->with('job', $job);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Job $job, JobBoard $board)
    {
        $this->authorize('viewAny', Job::class);
        
        $applicants = $board->applicants;

        return view('jobs.applicants')
            ->with('applicants', ApplicantResource::collection($applicants))
            ->with('board', $board)
            ->with('job', $job);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Applicant $applicant)
    {
        $this->updateApplicantStatus($applicant, request()->all());

        $applicants = JobBoardResource::collection($applicant->job->jobBoards->fresh());

        if ( isset($_GET['b']) ) {
            $applicants = ApplicantResource::collection($this->getApplicant($_GET['b']));
        }

        return response()->json([
            'success' => 'Applicant Status has been Updated.',
            'applicants' => $applicants
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
