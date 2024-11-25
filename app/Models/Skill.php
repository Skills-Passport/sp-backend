<?php

namespace App\Models;

use App\Models\Rating;
use App\Models\Feedback;
use App\Models\Competency;
use App\Traits\PopulatesIfEmpty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Filters\SkillFilter;
class Skill extends Model
{

    use HasFactory, HasUuids, SoftDeletes, PopulatesIfEmpty;
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

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function getRatingAttribute()
    {
        return auth()->user()->skills()->where('skill_id', $this->id)->first()->pivot->last_rating;
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
