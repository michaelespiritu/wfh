<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'message' => $this->message,
            'owner' => $this->owner,
            'sent_at' => $this->created_at->format('M. j, Y h:i:s'),
        ];
    }
}
