<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'rating' => $this->new_rating,
            'approved_at' => $this->approved_at,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
