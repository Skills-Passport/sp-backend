<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SkillEndorsementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $queue = 'notifications';
    protected $endorsement;

    /**
     * Create a new notification instance.
     */
    public function __construct(object $endorsement)
    {
        $this->endorsement = $endorsement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You Received a Skill Endorsement')
            ->line('You have been endorsed for the skill: ' . $this->endorsement->skill->title)
            ->action('View Endorsement', url('/endorsements/' . $this->endorsement->id))
            ->line('Thank you for using our application!');
    }


    /**
     * Get the array representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'endorsement_id' => $this->endorsement->id,
            'message' => 'You have been endorsed for the skill: ' . $this->endorsement->skill->title,
            'skill' => $this->endorsement->skill->title,
            'created_by' => $this->endorsement->created_by,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
