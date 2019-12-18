@extends('layouts.admin')


@section('content')
<div class="container-fluid">
  <!-- Page Heading --> 
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('jobs.show', $job) }}" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-chevron-left fa-sm text-white-50"></i> Back</a>

    <div>
        <ul class="list-inline mb-0">

            @foreach( $job->jobBoards as $jobBoard )
            <li class="list-inline-item"><a href="{{ route('applicants.index', [$job->identifier, $jobBoard->identifier]) }}" class="w-full d-sm-inline-block btn btn-sm badge-{{ $jobBoard->name }} btn-primary shadow-sm">{{ $jobBoard->name }}</a></li>

            @endforeach

            <li class="list-inline-item"><a href="{{ route('applicants.manage', $job) }}" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-wrench"></i> Manage Applicant</a></li>

        </ul>
        
    </div>

  </div>
</div>
<div class="container-fluid">
    <applicants 
            :board="{{ $board }}"
            :boards="{{ $job->jobBoards }}"
            :applicants="{{ json_encode($applicants) }}">
            </applicants>
</div>

@endsection