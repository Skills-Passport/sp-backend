<?php

namespace App\Modules\Skills\Resources\Students;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Competencies\Resources\Teachers\CompetencyResource;

class SkillResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'groups_count' => $this->groups_count,
            'competency' => new CompetencyResource($this->whenLoaded('competency')),
            'is_added' => $this->is_added,
            'rating' => $this->is_added ? $this->rating : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}