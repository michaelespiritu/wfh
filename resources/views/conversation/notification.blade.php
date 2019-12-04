 <!-- Dropdown - Messages -->
 <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
    <h6 class="dropdown-header">
        Message Center
    </h6>
    
        @forelse(auth()->user()->accessibleProjects() as $conversation)
        <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="dropdown-list-image mr-3">
                <img 
                    class="rounded-circle" 
                    src="{{ $conversation->owner->profile_image }}" 
                    alt="{{ $conversation->owner->name }}">
                <div class="status-indicator bg-success"></div>
            </div>
            <div class="font-weight-bold">
                <div class="text-truncate">{{ Helpers::cutConvertedText($conversation->latestMessage()->message, 35) }}</div>
                <div class="small text-gray-500">{{ $conversation->latestMessage()->owner->name }} · {{ $conversation->latestMessage()->created_at->format('M. j, Y') }}</div>
            </div>
        </a>
        @empty
        <a class="dropdown-item d-flex align-items-center" href="#">
            <p class="mb-0 m-auto">No Message</p>
        </a>
        @endforelse
    
    <a class="dropdown-item text-center small text-gray-500" href="{{ route('conversation.index') }}">Read More Messages</a>
</div>