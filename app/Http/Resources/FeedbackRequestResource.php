<?php

namespace App\Http\Resources;

use App\Http\Resources\Educator\SkillResource as EducatorSkillResource;
use App\Http\Resources\Student\SkillResource as StudentSkillResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $SkillResource = auth()->user()->hasRole('student') ? StudentSkillResource::class : EducatorSkillResource::class;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'requester' => new UserResource($this->whenLoaded('requester')),
            'recipient' => new UserResource($this->whenLoaded('recipient')),
            'skill' => new $SkillResource($this->whenLoaded('skill')),
            'group' => new GroupResource($this->whenLoaded('group')),
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
