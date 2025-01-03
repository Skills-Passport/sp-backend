<?php

namespace App\Http\Resources;

use App\Http\Resources\GroupResource;
use App\Http\Resources\SkillResource;
use App\Http\Resources\FeedbackResource;
use App\Http\Resources\EndorsementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->first_name.' '.$this->last_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'job_title' => $this->job_title,
            'personal_coach' => $this->personal_coach ? self::make($this->whenLoaded('personalCoach')) : null,
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'groups' => GroupResource::collection($this->whenLoaded('groups')),
            'feedbacks' => FeedbackResource::collection($this->whenLoaded('feedbacks')),
            'endorsements' => EndorsementResource::collection($this->whenLoaded('endorsements')),
            'address' => $this->address,
            'field' => $this->field,
            'image' => $this->image,
            'email' => $this->email,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'role' => $this->role ? [
                'id' => $this->role->id,
                'name' => $this->role->name,
            ] : null,
            'is_teacher' => $this->is_teacher,
            'is_admin' => $this->is_admin,
            'is_head_teacher' => $this->is_head_teacher,
        ];
    }
}
