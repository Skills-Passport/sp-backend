<?php

namespace App\Http\Resources;

use App\Http\Resources\Educator\SkillResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'students' => UserResource::collection($this->whenLoaded('students')),
            'teachers' => UserResource::collection($this->whenLoaded('teachers')),
            'students_count' => $this->students? $this->students->count() : 0,
        ];
    }
}
