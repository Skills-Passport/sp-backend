<?php

namespace App\Events;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExternalEndorsementRequested
{
    use Dispatchable, SerializesModels;

    public $requester;

    public $requestee_email;

    public $skill;

    public $title;

    public function __construct(User $requester, string $requestee_email, Skill $skill, string $title)
    {
        $this->requester = $requester;
        $this->requestee_email = $requestee_email;
        $this->skill = $skill;
        $this->title = $title;
    }
}
