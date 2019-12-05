@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  <!-- Page Heading --> 
  <div class="d-sm-flex justify-content-between align-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Conversation</h1>
  </div>
</div>

<div class="container-fluid">
        
    <my-conversation :conversations="{{ json_encode( auth()->user()->accessibleConversations() ) }}"></my-conversation>

</div>

@endsection

