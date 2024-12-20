<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public const TYPE_FEEDBACK_REQUEST = 'FeedbackRequest';

    public const TYPE_FEEDBACK_RECEIVED = 'FeedbackReceived';

    public const TYPE_ENDORSEMENT_REQUEST = 'EndorsementRequest';

    public const TYPE_ENDORSEMENT_RECEIVED = 'EndorsementReceived';

    public const TYPE_ENDORSEMENT_REQUEST_REVIEW = 'EndorsementRequestReview';
}
