<?php

namespace App\Listeners;

use App\Events\FeedbackAnswered;
use App\Models\Feedback;
use App\Notifications\FeedbackReceivedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleFeedbackAnswered implements ShouldQueue
{
    public $queue = 'feedbacks';

    public function handle(FeedbackAnswered $event)
    {
        $feedback = Feedback::create($event->requestDetails());
        $event->feedbackRequest->requester->notify(new FeedbackReceivedNotification($feedback));
    }
}
