<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'company' => UserResource::make($this->owner),
            'title' => $this->title,
            'category' => CategoryResource::make($this->category),
            'region_restriction' => $this->region_restriction,
            'notify_email' => $this->notify_email,
            'type' => $this->type,
            'budget' => $this->allotedBudget(),
            'budget_raw' => $this->budget,
            'skills' => $this->skills,
            'description' => $this->description,
            'excerpt' => strip_tags(Str::limit($this->description,350)),
            'path' => $this->path(),
            'public_path' => $this->applicantPath(),
            'apply_path' => $this->jobApplyPath(),
            'created_at' => $this->created_at->format('M d, Y'),
            'boards' => $this->jobBoards
        ];
    }
}
