<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'group_id',
        'requester_id',
        'recipient_id',
        'skill_id',
    ];

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