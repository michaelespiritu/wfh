<template>
    <div>
        <div class="d-md-flex align-items-center justify-center py-2 px-2 border-bottom text-md-left text-center">
            <!-- <div class="pr-md-3">
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
            </div> -->
        </div>
    </div>
</template>