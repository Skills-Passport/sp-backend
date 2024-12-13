<?php

namespace App\Listeners;

use App\Events\FeedbackRequested;
use App\Models\FeedbackRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFeedbackRequestedNotification implements ShouldQueue
{
    public $queue = 'feedbacks';

    public function handle(FeedbackRequested $event)
    {
        $feedbackRequest = FeedbackRequest::create($event->requestDetails());

        $event->recipient->notify(new \App\Notifications\FeedbackRequestedNotification($feedbackRequest));
    }
}
