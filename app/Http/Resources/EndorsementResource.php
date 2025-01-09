<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EndorsementResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'skill' => SkillResource::make($this->whenLoaded('skill')),
            'content' => $this->content,
            'created_by' => UserResource::make($this->whenLoaded('createdBy')),
            'created_by_email' => $this->created_by_email,
            'title' => $this->title,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
