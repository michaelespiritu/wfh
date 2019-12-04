@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  <!-- Page Heading --> 
  <div class="d-sm-flex justify-content-between align-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Conversation</h1>
  </div>
</div>

<div class="container-fluid">

    <div class="row">
        <div class="col-3 border border py-0 px-0">
            @forelse(auth()->user()->accessibleProjects() as $conversation)
                <div class="d-md-flex align-items-center justify-center py-2 px-2 border-bottom text-md-left text-center">
                    <div class="pr-md-3">
                        <img 
                            class="rounded-circle" 
                            src="{{ $conversation->owner->profile_image }}" 
                            alt="{{ $conversation->owner->name }}"
                            width="50"
                            height="50">
                    </div>
                    <div>
                        <p class="text-gray-500 mb-0">{{ $conversation->members->implode('name', ', ') }}</p>
                        <p class="small text-gray-500 mb-0">{{ $conversation->latestMessage()->created_at->format('M. j, Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="mb-0 m-auto">No Message</p>
            @endforelse
        </div>
        <div class="col-9 border border py-0 px-0">
        </div>
    </div>

</div>


@endsection

