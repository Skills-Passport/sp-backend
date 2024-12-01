<?php

namespace App\Listeners;

use App\Events\SendExternalEndorsementEmail;
use App\Notifications\ExternalEndorsementRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendExternalEndorsementEmailListener implements ShouldQueue
{
    public $queue = 'emails';

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(SendExternalEndorsementEmail $event)
    {
        $endorsementRequest = $event->endorsementRequest;

        Notification::route('mail', $endorsementRequest->requestee_email)
            ->notify(new ExternalEndorsementRequestNotification($endorsementRequest));
    }
}
