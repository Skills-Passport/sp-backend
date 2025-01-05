<?php

namespace App\Models;

use App\Filters\SkillFilter;
use App\Traits\PopulatesIfEmpty;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Skill extends Model
{
    use HasFactory, HasUuids, PopulatesIfEmpty, SoftDeletes;

    protected $fillable = [
        'title',
        'desc',
        'created_by',
        'competency_id',
    ];

    protected $withs = [
        'competency',
        'users',
        'groups',
        'ratings',
        'feedbacks',
        'endorsements',
        'timelines',
    ];

    protected $appends = [
        'ratings'
    ];

    protected static function booted(): void
    {
        static::creating(function ($skill) {
            if ($skill->created_by === null) {
                $skill->created_by = auth()->id();
            }
        });
    }

    public function competency()
    {
        return $this->belongsTo(Competency::class)->whereNull('deleted_at');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'skill_user', 'skill_id', 'user_id')
            ->withPivot('last_rating');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_skills', 'skill_id', 'group_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function endorsements()
    {
        return $this->hasMany(Endorsement::class);
    }

    public function timelines()
    {
        return $this->hasMany(Timeline::class, 'skill_id');
    }

    public function timeline(User $user)
    {
        return $this->timelines()->where('user_id', $user->id);
    }

    public function getRatingAttribute()
    {
        return auth()->user()->skills()->where('skill_id', $this->id)->first()->pivot->last_rating;
    }

    public function getGroupsCountAttribute()
    {
        return $this->groups()->count();
    }

    public function getFeedbacksCountAttribute()
    {
        return $this->feedbacks()->count();
    }

    public function getEndosementsCountAttribute()
    {
        return $this->endorsements()->count();
    }

    public function IsSkillAdded(User $user = null)
    {
        if ($user === null) {
            $user = auth()->user();
        }
        return $this->users()->where('user_id', auth()->id())->exists();
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        return (new SkillFilter($request))->filter($query);
    }
}
