@extends('layouts.admin')


@section('content')
<div class="container-fluid">
  <!-- Page Heading --> 
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('jobs.show', $job) }}" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-chevron-left fa-sm text-white-50"></i> Back</a>

    <div>
        <ul class="list-inline mb-0">

            <li class="list-inline-item"><a href="{{ route('applicants.index', [$job, 'type' => 'Waiting']) }}" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-hourglass-start"></i> Waiting</a></li>

            <li class="list-inline-item"><a href="{{ route('applicants.index', [$job, 'type' => 'Shortlist']) }}" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-check"></i> Shortlist</a></li>

            <li class="list-inline-item"><a href="{{ route('applicants.index', [$job, 'type' => 'Reject']) }}" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-calendar"></i> Rejected</a></li>

            <li class="list-inline-item"><a href="{{ route('applicants.manage', $job) }}" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-wrench"></i> Manage Applicant</a></li>


        </ul>
    </div>

  </div>
</div>
<div class="container-fluid">
    <applicants 
            :boards="{{ $job->jobBoard }}"
            type="{{ $type }}"
            :applicants="{{ json_encode($applicants) }}">
            </applicants>
</div>

@endsection