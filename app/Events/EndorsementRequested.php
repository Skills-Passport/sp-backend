<?php

namespace App\Events;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EndorsementRequested
{
    use Dispatchable, SerializesModels;

    public $requester;

    public $requestee;

    public $skill;

    public $title;

    public function __construct(User $requester, User $requestee, Skill $skill, string $title)
    {
        $this->requester = $requester;
        $this->requestee = $requestee;
        $this->skill = $skill;
        $this->title = $title;
    }

    public function requestDetails(): array
    {
        return [
            'requester_id' => $this->requester->id,
            'requestee_id' => $this->requestee->id,
            'skill_id' => $this->skill->id,
            'title' => $this->title,
        ];
    }
}
