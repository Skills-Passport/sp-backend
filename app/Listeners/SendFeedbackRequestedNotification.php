<?php

namespace App\Listeners;

use App\Events\FeedbackRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFeedbackRequestedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(FeedbackRequested $event)
    {
        $requestDetails = $event->requestDetails();

        $event->recipient->notify(new \App\Notifications\FeedbackRequestedNotification($requestDetails));
    }
}
