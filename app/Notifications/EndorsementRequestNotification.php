<?php

namespace App\Notifications;

use App\Http\Resources\Educator\SkillResource;
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
            'mail' => 'endorsements'
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
            'type' => 'endorsement',
            'event' => 'request',
            'requester' => UserResource::make($this->endorsementRequest->requester),
            'skill' => SkillResource::make($this->endorsementRequest->skill),
            'title' => $this->endorsementRequest->title,
            'created_at' => $this->endorsementRequest->created_at,
        ];
    }
}
