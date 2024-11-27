<?php

namespace App\Http\Resources\Educator;

use App\Http\Resources\CompetencyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'groups_count' => $this->groups_count,
            'is_added' => $this->is_added,
            'ratings' => $this->is_added ? $this->ratings : null,
            'competency' => new CompetencyResource($this->whenLoaded('competency')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'rating' => $this->is_added ? $this->rating : null,
        ];
    }
}
