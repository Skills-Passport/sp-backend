<?php

namespace App\Events;

use App\Models\EndorsementRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExternalEndorsementRequestFilled
{
    use Dispatchable, SerializesModels;

    public $request;

    public $data;

    public $requester;

    public function __construct(EndorsementRequest $request, $data)
    {
        $this->request = $request;
        $this->requester = User::find($request->requester_id);
        $this->data = $data;
    }

    public function requestDetails(): array
    {
        return [
            'type' => Notification::TYPE_ENDORSEMENT_REQUEST_REVIEW,
            'requester' => $this->requester,
            'requestee_name' => $this->data['supervisor_name'],
            'request_id' => $this->request->id,
        ];
    }
}
