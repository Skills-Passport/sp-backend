<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->data['type'],
            'requester' => $this->data['requester'] ?? null,
            'skill' => $this->data['skill'] ?? null,
            'requestee_name' => $this->requester ? $this->requester->name : null,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
