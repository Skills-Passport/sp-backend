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

        $feedback = new Feedback($event->requestDetails());

        $event->feedbackRequest->user->notify(new FeedbackReceivedNotification($feedback));
    }
}