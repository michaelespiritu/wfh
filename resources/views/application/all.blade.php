@extends('layouts.admin')

@section('content')

<div class="row">
@forelse($applications as $application)
    <div class="col-sm-12 col-md-6">
        <div 
            class="card px-3 py-3 mb-3 cursor-pointer">
            <a 
                class="text-decoration-none text-gray-900"
                href="{{ route('application.show', $application) }}">
                <div class="">
                    <div class="text-center text-lg-left">
                        <p itemprop="title" class="h4">
                            {{ $application->job->title }}
                        </p>

                        <p class="text-muted">
                            <span itemprop="hiringOrganization" itemscope="itemscope" itemtype="http://schema.org/Organization">
                                <span itemprop="name">
                                    {{ $application->job->owner->companyName() }}
                                </span>
                            </span>
                            &#8226; 
                            <small>
                                <span itemprop="employmentType">
                                    <i class="fas fa-business-time"></i> {{ $application->job->type }} 
                                </span> 
                                &#8226; 
                                <span itemprop="baseSalary">
                                    <i class="fas fa-money-bill-alt"></i> {{ $application->job->allotedBudget() }}
                                </span>
                            </small>
                        </p>


                        <p class="mb-0">
                            <span class="badge badge-{{ $application->status }}">{{ $application->status }}</span>
                            &#8226;
                            <small>
                                <span>
                                    <a href="#">{{ $application->job->category->name }}</a>
                                </span>
                                &#8226; 
                                <span itemprop="datePosted">
                                    Date Applied: {{ $application->created_at->format('M d, Y') }}
                                </span>
                            </small>
                        </p>
                    </div>

                </div>
            </a>
            
        </div>
    </div>

@empty

    <div class="text-center mt-5 col-12">
        <p class="h3">No Application Yet.</p>
        <p>Click <a href="{{ route('app.jobs.index') }}">here</a> to view latest Jobs.</p>
    </div>
@endforelse
</div>
@endsection
