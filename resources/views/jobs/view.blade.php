@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  <!-- Page Heading --> 
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="/jobs" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-chevron-left fa-sm text-white-50"></i> Back</a>
        <board-create :job="{{ json_encode($job) }}"></board-create>

    </div>

    <div>
        <ul class="list-inline mb-0">
            <li class="list-inline-item"><a href="{{ route('app.jobs.show', $job) }}" target="_blank" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-external-link-alt fa-sm text-white-50"></i></a></li>
            <li class="list-inline-item"><a href="{{ $job->path() }}/edit" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-pen fa-sm text-white-50"></i></a></li>
            <li class="list-inline-item"><remove-job :job="{{ json_encode($job) }}"></remove-job></li>
        </ul>
    </div>
  </div>
</div>

<div class="container-fluid">

    <div class="row">
        <div class="col-6 col-xl-3 col-md-3 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <a class="text-decoration-none text-gray-900" href="{{ route('applicants.manage', $job) }}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Applicant
                            </div>
                            <div class="h5 mb-0">
                                {{ $job->applicantCountTextOutput() }}
                            </div>
                            
                        </div>
                    </div>
                </a>
            </div>
            </div>
        </div>

        @foreach( $job->jobBoards as $board )
        <div class="col-6 col-xl-3 col-md-3 mb-4">
            <div class="card border-left-{{ $board->name }} shadow h-100 py-2">
                <a class="text-decoration-none text-gray-900" href="{{ route('applicants.index', [$job->identifier, $board->identifier]) }}">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ $board->name }} text-uppercase mb-1">
                                {{ $board->name }}
                            </div>
                            <div class="h5 mb-0">
                                {{ $job->applicantCountTextOutput($board->identifier) }}
                            </div>
                            
                        </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
        
    </div> 

    <div class="card shadow mb-4">
        <div class="card-body">
            <h1 class="h3 text-center text-md-left text-gray-800">{{ $job->title }}</h1>

            <div class="d-md-flex justify-content-between align-items-center">
                <div class="text-center text-md-left">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><i class="fas fa-money-bill-alt"></i> {{ $job->allotedBudget() }}</li>
                        <li class="list-inline-item"><i class="fas fa-business-time"></i> {{ $job->type }}</li>
                    </ul>

                    <ul class="list-inline mb-0">
                        @foreach($job->skills as $skill)
                            <li class="list-inline-item">
                                <span class="badge badge-primary rounded-0 px-2">{{ $skill }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="text-center text-md-right">
                    <p class="mb-0">
                        <a href="">{{ $job->category->name }}</a>
                    </p>
                    <p class="mb-0">
                        {{ $job->region_restriction }}
                    </p>
                </div>
            </div>

            <div id="jobDescription" class="my-4 description-data">
                {!! $job->description !!}
            </div>

            <div class="text-center">
                <p id="showDesc" class="cursor-pointer btn btn-primary btn-sm mx-auto" onClick="showMore()">Show More</p>
            </div>

        </div>

    </div>


    <div class="text-muted text-center">
        <p >Email Address will be notified when someone applied: </p>
        <ul class="list-inline mb-0">
        @foreach($job->notify_email as $email)
            <li class="list-inline-item">
                {{ $email }}
            </li>
        @endforeach
        </ul>
    </div>
</div>

@endsection

@section('script')
<script>
    function showMore ()
    {
        document.getElementById('jobDescription').classList.toggle('h-50')

        if ( document.getElementById('showDesc').innerHTML == 'Show More')
        {
            document.getElementById('showDesc').innerHTML = 'Show Less'
        } else {
            document.getElementById('showDesc').innerHTML = 'Show More'
        }
    }
</script>
@endsection
