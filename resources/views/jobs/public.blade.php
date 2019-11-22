@extends('layouts.admin')


@section('content')

  <!-- Page Heading --> 
<div class="text-center">

<h1 class="mb-0  pt-3 font-weight-bolder">{{ $job->title }}</h1>
<p class="mb-0 "><small>Posted: {{$job->created_at->format('M d, Y')}}</small></p>

@if(!auth()->user()->isEmployer())
<apply-job :job="{{ json_encode($job) }}"></apply-job>
@endif

</div>

<div class="container mt-4">

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-body">

            <div class="d-sm-flex justify-content-between align-items-center">
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
                        <a href="#">{{ $job->category->name }}</a>
                    </p>
                    <p class="mb-0">
                        {{ $job->region_restriction }}
                    </p>
                </div>
            </div>

           

            <div class="my-4">
                {!! $job->description !!}
            </div>

        </div>

    </div>

</div>

@endsection
