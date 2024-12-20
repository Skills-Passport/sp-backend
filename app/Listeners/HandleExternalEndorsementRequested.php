<?php

namespace App\Listeners;

use App\Events\ExternalEndorsementRequested;
use App\Events\SendExternalEndorsementEmail;
use App\Models\EndorsementRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleExternalEndorsementRequested implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'endorsements';

    public function handle(ExternalEndorsementRequested $event)
    {
        $endorsementRequest = EndorsementRequest::create($event->requestDetails());
        event(new SendExternalEndorsementEmail($endorsementRequest));
    }
}
