<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ExternalEndorsementRequestFilled;
use App\Notifications\ExternalEndorsementRequestFilledNotification;

class HandleExternalEndorsementRequestFilled implements ShouldQueue
{
    use InteractsWithQueue;
    public $queue = 'endorsements';

    public function handle(ExternalEndorsementRequestFilled $event)
    {
        $event->requester->personalCoach->notify(new ExternalEndorsementRequestFilledNotification($event->requestDetails()));
    }
}
