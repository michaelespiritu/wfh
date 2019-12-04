@extends('layouts.admin')

@section('content')

<div class="row">
@forelse($jobs as $job)
    <div class="col-sm-12 col-md-6" >
        <div 
            class="card px-3 py-3 mb-3 cursor-pointer"
            >
            <a 
                class="text-decoration-none text-gray-900"
                href="{{ route('app.jobs.show', $job) }}">
            <div class="">
                <div class="text-center text-md-left">
                    <p itemprop="title" class="h4 mb-0">
                        {{ $job->title }}
                    </p>
                    <p class="text-muted">
                        <span itemprop="hiringOrganization" itemscope="itemscope" itemtype="http://schema.org/Organization">
                            <span itemprop="name">
                                {{ $job->owner->companyName() }}
                            </span>
                        </span>
                        &#8226; 
                        <small>
                            <span itemprop="employmentType">
                                <i class="fas fa-business-time"></i> {{ $job->type }} 
                            </span> 
                            &#8226; 
                            <span itemprop="baseSalary">
                                <i class="fas fa-money-bill-alt"></i> {{ $job->allotedBudget() }}
                            </span>
                        </small>
                    </p>
                   
                </div>
            </div>
            

            <div itemprop="description" class="text-left mb-3 text-truncate">
                {!! Helpers::cutConvertedText($job->description, 250) !!}
            </div>

            <p class="mb-0">
                <small>
                    <span itemprop="datePosted">
                        Posted on: {{ $job->created_at->format('M d, Y') }} &#8226; <a href="#">{{ $job->category->name }}</a>
                    </span>
                </small>
            </p>

            </a>
        </div>
    </div>
@empty
    <div class="text-center mt-5 col-12">
        <p class="h3">No Job Posted Yet.</p>
    </div>
@endforelse
</div>
@endsection
