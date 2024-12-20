<?php

namespace App\Notifications;

use App\Models\EndorsementRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification as BaseNotification;

class ExternalEndorsementRequestFilledNotification extends BaseNotification implements ShouldQueue
{
    use Queueable;


    public function viaQueues(): array
    {
        return [
            'database' => 'endorsements'
        ];
    }
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }
    public function toArray($notifiable): array
    {
        return $this->request;
    }
}