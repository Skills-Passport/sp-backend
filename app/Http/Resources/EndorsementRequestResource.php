<?php

namespace App\Http\Resources;

use App\Models\Endorsement;
use Illuminate\Http\Resources\Json\JsonResource;

class EndorsementRequestResource extends JsonResource
{
    public function toArray($request)
    {
        $type = $this->requestee_email ? 'review' : 'request';

        return [
            'id' => $this->id,
            'requester' => new UserResource($this->whenLoaded('requester')),
            'requestee_email' => $this->when($type === 'review', $this->requestee_email),
            'requestee' => $this->when($type === 'review', $this->data),
            'skill' => new SkillResource($this->whenLoaded('skill')),
            'title' => $this->title,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
