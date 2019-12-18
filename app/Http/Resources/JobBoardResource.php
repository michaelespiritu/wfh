<?php

namespace App\Http\Resources;

use App\Http\Resources\ApplicantResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobBoardResource extends JsonResource
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
            'name' => $this->name,
            'applicants' => ApplicantResource::collection($this->applicants),
        ];
    }
}
