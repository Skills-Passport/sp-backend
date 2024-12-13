<?php

namespace App\Events;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class FeedbackRequested
{
    use Dispatchable, SerializesModels;

    public $requester;

    public $recipient;

    public $skill;

    public $title;

    public function __construct(User $requester, User $recipient, Skill $skill, string $title)
    {
        $this->requester = $requester;
        $this->recipient = $recipient;
        $this->skill = $skill;
        $this->title = $title;
    }

    public function requestDetails(): array
    {
        return [
            'requester_id' => $this->requester->id,
            'recipient_id' => $this->recipient->id,
            'skill_id' => $this->skill->id,
            'title' => $this->title,
        ];
    }
}
