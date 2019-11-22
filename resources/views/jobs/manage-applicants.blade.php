@extends('layouts.admin')

@section('style')
<style>
.dragArea {
    min-height: 550px;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
  <!-- Page Heading --> 
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('jobs.show', $job) }}" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-chevron-left fa-sm text-white-50"></i> Back</a>
  </div>
</div>
<div class="container-fluid">
    <manage-applicants 
            :waiting="{{ json_encode($waiting) }}"
            :shortlist="{{ json_encode($shortlist) }}"
            :reject="{{ json_encode($reject) }}">
            </manage-applicants>
</div>

@endsection