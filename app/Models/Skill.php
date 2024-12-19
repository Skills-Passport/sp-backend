<?php

namespace App\Models;

use App\Models\Endorsement;
use App\Filters\SkillFilter;
use Illuminate\Http\Request;
use App\Traits\PopulatesIfEmpty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory, HasUuids, PopulatesIfEmpty, SoftDeletes;

    protected $fillable = [
        'title',
        'desc',
        'competency_id',
    ];

    public function competency()
    {
        return $this->belongsTo(Competency::class);
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

    public function getIsAddedAttribute()
    {
        return $this->users()->where('user_id', auth()->id())->exists();
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        return (new SkillFilter($request))->filter($query);
    }
}
