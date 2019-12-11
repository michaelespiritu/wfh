 <!-- Dropdown - Messages -->
 <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
    <h6 class="dropdown-header">
        Message Center
    </h6>
        @forelse(auth()->user()->accessibleConversations() as $conversation)
        <a class="dropdown-item d-flex align-items-center {{ ( !$conversation->wasRead() ) ? 'bg-dark text-white' : '' }}" onClick="document.cookie = '__wfh_message_target=/conversation/{{ $conversation->identifier }}; path=/'" href="{{ route('conversation.index') }}">
            <div class="dropdown-list-image mr-3">

                @if(!auth()->user()->isEmployer())
                    <img 
                        class="rounded-circle" 
                        src="{{ $conversation->owner->profile_image }}" 
                        alt="{{ $conversation->owner->name }}">
                @else

                    <img 
                        class="rounded-circle" 
                        src="{{ $conversation->latestMember()->profile_image }}" 
                        alt="{{ $conversation->latestMember()->name }}">

                @endif

                <div class="status-indicator bg-success"></div>

            </div>
            <div class="font-weight-bold">

                <div class="text-truncate">
                    {{ Helpers::cutConvertedText($conversation->latestMessage()->message, 35) }}
                </div>

                @if(!auth()->user()->isEmployer())

                    <div class="small text-gray-500">
                        {{ $conversation->owner->name }} · {{ $conversation->latestMessage()->created_at->format('M. j, Y') }}
                    </div>

                @else

                    <div class="small text-gray-500">
                        {{ $conversation->members->implode('name', ', ') }} · {{ $conversation->latestMessage()->created_at->format('M. j, Y') }}
                    </div>

                @endif

            </div>

        </a>
        @empty
        <a class="dropdown-item d-flex align-items-center" href="#">
            <p class="mb-0 m-auto">No Message</p>
        </a>
        @endforelse
    
    <a class="dropdown-item text-center small text-gray-500" href="{{ route('conversation.index') }}">Read More Messages</a>
</div>