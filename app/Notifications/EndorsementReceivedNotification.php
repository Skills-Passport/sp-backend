<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EndorsementReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function viaQueues(): array
    {
        return [
            'database' => 'endorsements',
        ];
    }

    protected $endorsement;

    /**
     * Create a new notification instance.
     */
    public function __construct($endorsement)
    {
        $this->endorsement = $endorsement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => \App\Models\Notification::TYPE_ENDORSEMENT_RECEIVED,
            'requestee_name' => $this->endorsement->createdBy->name,
            'skill' => [
                'id' => $this->endorsement->skill->id,
                'title' => $this->endorsement->skill->title,
            ],
            'created_at' => $this->endorsement->created_at,
        ];
    }
}