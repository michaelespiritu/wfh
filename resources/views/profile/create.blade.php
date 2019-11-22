@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    
    <create-profile class="mb-4" :user="{{ json_encode(auth()->user()) }}"></create-profile>

    @if(!auth()->user()->isEmployer())
    <applicant-meta></applicant-meta>
    @else
    <employer-meta></employer-meta>
    @endif

</div>

@endsection
