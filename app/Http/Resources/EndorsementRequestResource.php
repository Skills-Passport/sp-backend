<?php

namespace App\Http\Resources;

use App\Http\Resources\SkillResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EndorsementRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'requester' => $this->requester,
            'skill' => new SkillResource($this->whenLoaded('skill')),
            'title' => $this->title,
        ];
    }
}
