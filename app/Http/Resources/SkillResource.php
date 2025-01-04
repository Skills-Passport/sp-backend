<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Resources\CompetencyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    public function toArray($request)
    {
        $user = $request->get('student') ? User::find($request->get('student')) : $request->user();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'desc' => $this->desc,
            'groups_count' => $this->groups_count,
            'competency' => new CompetencyResource($this->whenLoaded('competency')),
            'ratings' => $this->when($user->isStudent && $this->is_added, $this->whenLoaded('ratings', function () {
                return $this->ratings->map(function ($rating) {
                    return [
                        'rating' => $rating->new_rating,
                        'created_at' => $rating?->created_at->format('Y-m-d H:i:s'),
                        'approved_at' => $rating?->approved_at?->format('Y-m-d H:i:s'),
                    ];
                });
            })),
            'count_feedbacks' => $this->whenLoaded('feedbacks', $this->feedbacks->count()),
            'count_endorsements' => $this->whenLoaded('endorsements', $this->endorsements->count()),
            'is_added' => $this->when($user->isStudent, $this->is_added),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'groups' => $this->when($user->isTeacher, $this->whenLoaded('groups')),
        ];
    }
}
