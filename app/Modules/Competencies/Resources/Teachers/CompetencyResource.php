<?php

namespace App\Modules\Competencies\Resources\Teachers;

use Illuminate\Http\Resources\Json\JsonResource;

class CompetencyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titlte' => $this->name,
            'desc' => $this->desc,
            'overview' => $this->overview,
            'created_at' => $this->created_at,
        ];
    }
}