@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  <!-- Page Heading --> 
  <div class="d-sm-flex justify-content-between align-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buy Credit</h1>
    <p class="mb-0">You have: {{ auth()->user()->employerCredit->credit }} Job Credit left.</p>
  </div>
</div>

<div class="container-fluid">

<div class="card">
    <div class="card-body">

            <buy-credit></buy-credit>
    
    </div>
</div>


</div>


@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
@endsection
