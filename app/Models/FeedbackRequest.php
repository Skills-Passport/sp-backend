<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackRequest extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'title',
        'status',
        'group_id',
        'requester_id',
        'recipient_id',
        'skill_id',
    ];

    public const STATUS_PENDING = 'pending';

    public const STATUS_ANSWERED = 'answered';

    public const STATUS_DECLINED = 'declined';

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
