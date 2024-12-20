<?php


namespace App\Notifications;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Bus\Queueable;
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

    protected $data;
    public function __construct(Feedback $fb)
    {
        $this->feedback = $fb;
        $this->data = [
            'type' => \App\Models\Notification::TYPE_FEEDBACK_RECEIVED,
            'requestee' => UserResource::make(User::find($fb->user_id)),
            'skill' => [
                'id' => $fb->skill_id,
                'title' => $fb->skill->title,
            ],
            'group' => $fb->skill->group? [
                'id' => $fb->skill->group->id,
                'name' => $fb->skill->group->name,
            ] : null,
            'content' => $fb->content,
            ];
    }

    public function via($notifiable): array
    {
        return ['database'];
    }
    public function toArray($notifiable): array
    {
        return $this->data;
    }
} 