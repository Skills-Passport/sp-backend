<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompetencyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'desc' => $this->desc,
            'overview' => $this->overview,
            'endosements_count' => $this->endosements_count,
            'feedbacks_count' => $this->feedbacks_count,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'profiles' => ProfileResource::collection($this->whenLoaded('profiles')),
        ];
    }
}
