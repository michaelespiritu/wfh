@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  <!-- Page Heading --> 
  <div class="d-sm-flex justify-content-between align-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">My Jobs</h1>
    <a href="/jobs/create" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Create Job</a>
  </div>
</div>

<div class="container-fluid">

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Applicant</th>
                  <th>Budget</th>
                  <th>Days Remaning</th>
                  <th class="no-sort text-center">View</th>
                  <th class="no-sort text-center">Edit</th>
                  <th class="no-sort text-center">Delete</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Applicant</th>
                  <th>Budget</th>
                  <th>Days Remaning</th>
                  <th class="no-sort text-center">View</th>
                  <th class="no-sort text-center">Edit</th>
                  <th class="no-sort text-center">Delete</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach (auth()->user()->jobs as $job)
                <tr>
                  <td>{{ $job->title }}</td>
                  <td>{{ $job->applicantCountTextOutput() }}</td>
                  <td>{{ $job->allotedBudget() }}</td>
                  <td>{{ $job->daysRemaining() }}</td>
                  <td>
                    <a class="btn btn-primary btn-sm btn-block" href="{{ $job->path() }}" role="button">
                      <i class="fas fa-eye text-white"></i>
                    </a>
                  </td>
                  <td>
                    <a class="btn btn-warning btn-sm btn-block" href="{{ $job->path() }}/edit" role="button">
                      <i class="fas fa-edit text-white"></i>
                    </a>
                  </td>
                  <td>
                    <remove-job :job="{{ json_encode($job) }}"></remove-job>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

</div>

@endsection

@section('script')
<link href="{{ asset('js/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}" defer></script>
<script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}" defer></script>
<script src="{{ asset('js/data-table.js') }}" defer></script>
@endsection
