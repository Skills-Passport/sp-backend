<?php

namespace App\Listeners;

use App\Models\FeedbackRequest;
use App\Events\FeedbackRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\FeedbackRequestedNotification;

class SendFeedbackRequestedNotification implements ShouldQueue
{
    public $queue = 'feedbacks';

    public function handle(FeedbackRequested $event)
    {
        $feedbackRequest = FeedbackRequest::create($event->requestDetails());

        $event->recipient->notify(new FeedbackRequestedNotification($feedbackRequest));
    }
}
