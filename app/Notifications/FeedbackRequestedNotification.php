<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FeedbackRequestedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $requestDetails;

    public function __construct(array $requestDetails)
    {
        $this->requestDetails = $requestDetails;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }
    public function toArray($notifiable): array
    {
        return [
            'type' => \App\Models\Notification::TYPE_FEEDBACK_REQUEST,
            'requester' => UserResource::make(User::find($this->requestDetails['requester_id'])),
            'skill' => [
                'id' => $this->requestDetails['skill_id'],
                'title' => Skill::find($this->requestDetails['skill_id'])->title,
            ],
        ];
    }
}