<?php

namespace App\Listeners;

use App\Models\Feedback;
use App\Events\FeedbackAnswered;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\FeedbackReceivedNotification;

class HandleFeedbackAnswered implements ShouldQueue
{
    public $queue = 'feedbacks';

    public function handle(FeedbackAnswered $event)
    {
        $feedback = Feedback::create($event->requestDetails());
        $event->feedbackRequest->requester->notify(new FeedbackReceivedNotification($feedback));
    }
}