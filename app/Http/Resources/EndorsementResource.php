<?php

namespace App\Http\Resources;

use App\Http\Resources\Educator\SkillResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EndorsementResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'skill' => SkillResource::make($this->whenLoaded('skill')),
            'created_by' => UserResource::make($this->whenLoaded('createdBy')),
            'created_by_email' => $this->created_by_email,
            'title' => $this->title,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
