<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
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
            'identifier' => $this->identifier,
            'cover_letter' => $this->cover_letter,
            'cover_excerpt' => strip_tags(Str::limit($this->cover_letter,350)),
            'date_applied' => $this->created_at->format('M d, Y'),
            'status' => $this->status,
            'user' => UserResource::make($this->user)
        ];
    }
}
