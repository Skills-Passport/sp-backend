<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ExternalEndorsementRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function viaQueues(): array
    {
        return [
            'mail' => 'emails',
        ];
    }
    protected $endorsementRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct($endorsementRequest)
    {
        $this->endorsementRequest = $endorsementRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject(__('notifications.endorsement_request.subject'))
            ->greeting(__('notifications.endorsement_request.greeting'))
            ->line(__('notifications.endorsement_request.body'))
            ->line(__('notifications.endorsement_request.from', ['name' => $this->endorsementRequest->requester->first_name . ' ' . $this->endorsementRequest->requester->last_name]))
            ->line(__('notifications.endorsement_request.skill', ['skill' => $this->endorsementRequest->skill->title]))
            ->action(__('notifications.endorsement_request.action', ['student' => $this->endorsementRequest->requester->first_name]), url(config('app.frontend_url') . '/endorsement-request/' . $this->endorsementRequest->id))
            ->line(__('notifications.endorsement_request.thanks'));
    }
}
