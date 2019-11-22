@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  <!-- Page Heading --> 
  <div class="mb-4">
    <a href="{{ $job->path() }}" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-chevron-left fa-sm text-white-50"></i> Back</a>
  </div>
</div>

<div class="container-fluid">
<div class="card">
  <div class="card-body">
    <h1 class="h3 mb-4 text-gray-800">Edit {{$job->title}}</h1>
    <edit-job :job="{{ json_encode($job) }}"></edit-job>
  </div>
</div>


</div>

@endsection
