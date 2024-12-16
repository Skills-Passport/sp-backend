<?php


namespace App\Notifications;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use App\Models\FeedbackRequest;
use App\Http\Resources\UserResource;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeedbackReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function viaQueues(): array
    {
        return [
            'database' => 'feedbacks'
        ];
    }
    public Feedback $feedback;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }
    public function toArray($notifiable): array
    {
        return [
            'type' => \App\Models\Notification::TYPE_FEEDBACK_RECEIVED,
            'sender' => UserResource::make(User::find($this->feedback->user_id)),
            'skill' => [
                'id' => $this->feedback->skill_id,
                'title' => $this->feedback->skill->title,
            ],
            'group' => $this->feedback->skill->group? [
                'id' => $this->feedback->skill->group->id,
                'name' => $this->feedback->skill->group->name,
            ] : null,
            'content' => $this->feedback->content,
        ];
    }
} 