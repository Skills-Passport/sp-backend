<?php

namespace App\Http\Resources;

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
            'address' => $this->address,
            'field' => $this->field,
            'image' => $this->image,
            'email' => $this->email,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'role' => $this->role ? [
                'id' => $this->role->id,
                'name' => $this->role->name,
            ] : null,

        ];
    }
}
