@extends('layouts.admin')

@section('content')

<div class="row">

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div >
                        <a 
                            class="text-xs font-weight-bold text-primary text-uppercase mb-1" 
                            href="{{ $application->job->owner->companyUrl() }}" 
                            target="_blank">
                        {{ $application->job->owner->companyName() }}
                        </a>
                    </div>
                    <div class="h5 mb-0">
                        <a  
                            class="font-weight-bold text-gray-800"
                            href="{{ route('app.jobs.show', $application->job) }}"
                            target="_blank">
                            {{ $application->job->title }}
                        </a>
                    </div>
                    <p class="mb-0 font-weight-bold text-gray-800"><small>{{ $application->job->category->name }}</small></p>
                    
                </div>
                <div class="col-auto">
                    <a href="{{ route('app.jobs.show', $application->job) }}" target="_blank">
                        <i class="fas fa-external-link-alt fa-2x text-gray-300"></i>
                    </a>
                </div>
                </div>
            </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-{{ $application->status->name }} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-{{ $application->status->name }} text-uppercase mb-1">Status</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $application->status->name }}</div>
                    <p class="mb-0"><small>Date applied: {{ $application->created_at->format('M d, Y') }}</small></p>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-{{ $application->status }}"></i>
                </div>
                </div>
            </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Cover Letter</h6>
                </div>
                <div class="card-body">
                    {!! $application->cover_letter !!}
                </div>
            </div>
        </div>
</div>
@endsection
