<?php

namespace App\Listeners;

use App\Events\ExternalEndorsementRequestFilled;
use App\Notifications\ExternalEndorsementRequestFilledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleExternalEndorsementRequestFilled implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'endorsements';

    public function handle(ExternalEndorsementRequestFilled $event)
    {
        $event->requester->personalCoach->notify(new ExternalEndorsementRequestFilledNotification($event->requestDetails()));
    }
}
