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

    public $queue = 'emails';

    public function handle(ExternalEndorsementRequested $event)
    {
        $endorsementRequest = EndorsementRequest::create([
            'title' => $event->title,
            'requester_id' => $event->requester->id,
            'requestee_email' => $event->requestee_email,
            'skill_id' => $event->skill->id,
            'request_token' => $this->generateToken(),
        ]);
        event(new SendExternalEndorsementEmail($endorsementRequest));
    }

    private function generateToken()
    {
        return bin2hex(random_bytes(32));
    }
}
