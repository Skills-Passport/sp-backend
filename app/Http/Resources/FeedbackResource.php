<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'user' => new UserResource($this->whenLoaded('user')),
            'skill' => new SkillResource($this->whenLoaded('skill')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_by' => new UserResource($this->whenLoaded('createdBy')),
        ];
    }
}
