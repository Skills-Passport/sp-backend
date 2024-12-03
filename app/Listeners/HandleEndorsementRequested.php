<?php

namespace App\Listeners;

use App\Events\EndorsementRequested;
use App\Models\EndorsementRequest;
use App\Notifications\EndorsementRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleEndorsementRequested implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(EndorsementRequested $event)
    {
        $endorsment_request = EndorsementRequest::create($event->requestDetails());

        $event->requestee->notify(new EndorsementRequestNotification($endorsment_request));
    }
}
