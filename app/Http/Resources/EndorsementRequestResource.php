<?php

namespace App\Http\Resources;

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
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
