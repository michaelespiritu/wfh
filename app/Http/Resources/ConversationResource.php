<?php

namespace App\Http\Resources;

use App\Http\Resources\MessageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'owner' => $this->owner,
            'members' => $this->members->implode('name', ', '),
            'latest_message' => [
                'sender' => $this->latestMessage()->from_id,
                'sent_at' => $this->latestMessage()->created_at->format('M. j, Y h:i'),
                'message' => $this->latestMessage()->message
            ],
            'latest_member' => [
                'data' => $this->latestMember(),
            ],
            'messages' => MessageResource::collection($this->messages),
            'unread' => $this->wasRead(),
            'path' => $this->path()
        ];
    }
}
