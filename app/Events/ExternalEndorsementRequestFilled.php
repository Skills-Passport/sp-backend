<?php

namespace App\Events;

use App\Models\EndorsementRequest;
use App\Models\Notification;
use App\Models\User;
use App\Models\Skill;
use App\Models\FeedbackRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ExternalEndorsementRequestFilled
{
    use Dispatchable, SerializesModels;

    public $request;
    public $data;

    public function __construct(EndorsementRequest $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function requestDetails(): array
    {
        return [
            'type' =>Notification::TYPE_ENDORSEMENT_REQUEST_REVIEW,
            'requester' => User::find($this->request->requester_id), 
            'reqeustee_name' => $this->data->supervisor_name, 
            
        ];
    }
}
