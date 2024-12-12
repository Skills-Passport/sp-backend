<?php

namespace App\Http\Resources;

use App\Http\Resources\Educator\SkillResource as EducatorSkillResource;
use App\Http\Resources\Student\SkillResource as StudentSkillResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    public function toArray($request)
    {
        $SkillResource = auth()->user()->hasRole('student') ? StudentSkillResource::class : EducatorSkillResource::class;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'user' => new UserResource($this->whenLoaded('user')),
            'skill' => new $SkillResource($this->whenLoaded('skill')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_by' => new UserResource($this->whenLoaded('createdBy')),
        ];
    }
}
