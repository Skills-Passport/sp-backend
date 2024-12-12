<?php 

namespace App\Http\Resources;

use App\Http\Resources\Student\SkillResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->data->type,
            'requester' => $this->data->requester,
            'skill' => $this->data->skill,
            'requestee_name' => $this->requester->name,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}   