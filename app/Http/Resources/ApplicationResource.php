<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'job' => JobResource::make($this->job),
            'date_applied' => $this->created_at->format('M d, Y'),
            'cover_letter' => $this->cover_letter,
            'path' => $this->path()
        ];
    }
}
