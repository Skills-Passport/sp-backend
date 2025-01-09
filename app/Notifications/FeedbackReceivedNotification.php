<?php

namespace App\Notifications;

use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class FeedbackReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function viaQueues(): array
    {
        return [
            'database' => 'feedbacks',
        ];
    }

    public Feedback $feedback;

    protected $data;

    public function __construct(Feedback $fb)
    {
        $this->feedback = $fb;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => \App\Models\Notification::TYPE_FEEDBACK_RECEIVED,
            'requestee_name' => $this->feedback->requestee_name,
            'skill' => [
                'id' => $this->feedback->skill_id,
                'title' => $this->feedback->skill->title,
            ],
            'group' => $this->feedback->skill->group ? [
                'id' => $this->feedback->skill->group->id,
                'name' => $this->feedback->skill->group->name,
            ] : null,
            'content' => $this->feedback->content,
        ];
    }
}
