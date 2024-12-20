<?php

namespace App\Notifications;

use App\Http\Resources\UserResource;
use App\Models\FeedbackRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class FeedbackRequestedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function viaQueues(): array
    {
        return [
            'database' => 'feedbacks',
        ];
    }

    public FeedbackRequest $feedbackRequest;

    public function __construct(FeedbackRequest $feedbackRequest)
    {
        $this->feedbackRequest = $feedbackRequest;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => \App\Models\Notification::TYPE_FEEDBACK_REQUEST,
            'requester' => UserResource::make(User::find($this->feedbackRequest->requester_id)),
            'title' => $this->feedbackRequest->title,
            'group' => $this->feedbackRequest->group ? [
                'id' => $this->feedbackRequest->group->id,
                'name' => $this->feedbackRequest->group->name,
            ] : null,
            'skill' => [
                'id' => $this->feedbackRequest->skill_id,
                'title' => $this->feedbackRequest->skill->title,
            ],
        ];
    }
}
