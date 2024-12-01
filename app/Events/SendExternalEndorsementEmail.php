<?php

namespace App\Events;

use App\Models\EndorsementRequest;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendExternalEndorsementEmail
{
    use Dispatchable, SerializesModels;

    public $endorsementRequest;

    /**
     * Create a new event instance.
     */
    public function __construct(EndorsementRequest $endorsementRequest)
    {
        $this->endorsementRequest = $endorsementRequest;
    }
}
