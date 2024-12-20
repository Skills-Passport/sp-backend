<?php

namespace App\Notifications;

use App\Http\Resources\UserResource;
use App\Models\EndorsementRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EndorsementRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function viaQueues(): array
    {
        return [
            'database' => 'endorsements',
        ];
    }

    public $endorsementRequest;

    public function __construct(EndorsementRequest $endorsementRequest)
    {
        $this->endorsementRequest = $endorsementRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => \App\Models\Notification::TYPE_ENDORSEMENT_REQUEST,
            'requester' => UserResource::make($this->endorsementRequest->requester),
            'requestee_name' => $this->endorsementRequest->requestee->name,
            'skill' => [
                'id' => $this->endorsementRequest->skill->id,
                'title' => $this->endorsementRequest->skill->title,
            ],
            'created_at' => $this->endorsementRequest->created_at,
        ];
    }
}
