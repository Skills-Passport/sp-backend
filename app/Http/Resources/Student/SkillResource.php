<?php

namespace App\Http\Resources\Student;

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
            'competency' => new CompetencyResource($this->whenLoaded('competency')),
            'ratings' => $this->whenLoaded('ratings', function () {
                return $this->ratings->map(function ($rating) {
                    return [
                        'rating' => $rating->new_rating,
                        'created_at' => $rating->pivot->created_at->format('Y-m-d H:i:s'),
                    ];
                });
            }),
            'is_added' => $this->is_added,  
            'rating' => $this->is_added ? $this->rating : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}