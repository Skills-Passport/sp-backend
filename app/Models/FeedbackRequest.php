<?php

namespace App\Models;

use App\Filters\Queries\FeedbackRequestFilter;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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

    protected $withs = ['recipient', 'requester', 'skill', 'group'];

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

    public function scopeFilter($query, Request $request)
    {
        return (new FeedbackRequestFilter($request))->filter($query);
    }
}
