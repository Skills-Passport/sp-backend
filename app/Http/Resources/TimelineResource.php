<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => class_basename($this->timelineable_type),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            class_basename($this->timelineable_type) => $this->timelineable ? $this->timelineable->resource() : null,

        ];
    }
}
