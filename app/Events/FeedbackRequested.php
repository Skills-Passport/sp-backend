<?php

namespace App\Events;

use App\Models\User;
use App\Models\Group;
use App\Models\Skill;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class FeedbackRequested
{
    use Dispatchable, SerializesModels;

    public User $requester;

    public User $recipient;

    public Skill $skill;

    public $title;

    public Group $group;

    public function __construct(User $requester, User $recipient, Skill $skill, string $title, Group $group = null)
    {
        $this->requester = $requester;
        $this->recipient = $recipient;
        $this->skill = $skill;
        $this->title = $title;
        $this->group = $group ?? null;
    }

    public function requestDetails(): array
    {
        return [
            'requester_id' => $this->requester->id,
            'recipient_id' => $this->recipient->id,
            'skill_id' => $this->skill->id,
            'group_id' => $this->group?->id,
            'title' => $this->title,
        ];
    }
}
