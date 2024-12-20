<?php

namespace App\Listeners;

use App\Events\FeedbackRequested;
use App\Models\FeedbackRequest;
use App\Notifications\FeedbackRequestedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFeedbackRequestedNotification implements ShouldQueue
{
    public $queue = 'feedbacks';

    public function handle(FeedbackRequested $event)
    {
        $feedbackRequest = FeedbackRequest::create($event->requestDetails());

        $event->recipient->notify(new FeedbackRequestedNotification($feedbackRequest));
    }
}
