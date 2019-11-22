@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  <!-- Page Heading --> 
  <div class="d-sm-flex justify-content-between align-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Job</h1>
    <p class="mb-0">You have: {{ auth()->user()->employerCredit->credit }} Job Credit left.</p>
  </div>
</div>

<div class="container-fluid">

<div class="card">
  <div class="card-body">
    <create-job credit="{{ auth()->user()->employerCredit->credit }}"></create-job>
  </div>
</div>


</div>

@endsection
