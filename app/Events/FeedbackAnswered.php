<?php

namespace App\Events;

use App\Models\FeedbackRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class FeedbackAnswered
{
    use Dispatchable, SerializesModels;

    public string $content;

    public FeedbackRequest $feedbackRequest;

    public function __construct(string $content, FeedbackRequest $feedbackRequest)
    {
        $this->content = $content;
        $this->feedbackRequest = $feedbackRequest;
    }

    public function requestDetails(): array
    {
        return [
            'user_id' => $this->feedbackRequest->requester_id,
            'created_by' => $this->feedbackRequest->recipient_id,
            'skill_id' => $this->feedbackRequest->skill_id,
            'group_id' => $this->feedbackRequest->group_id,
            'content' => $this->content,
        ];
    }
}
