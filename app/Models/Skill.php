<?php

namespace App\Models;

use App\Filters\SkillFilter;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    /** @use HasFactory<\Database\Factories\SkillFactory> */
    use HasFactory, SoftDeletes, HasUuids;
    protected $fillable = ['title', 'desc', 'competency_id'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $with = ['competency', 'ratings'];

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'skill_user')->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_skills')->withTimestamps();
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        return (new SkillFilter($request))->filter($query);
    }

    public function getIsAddedAttribute()
    {
        return $this->users()->where('user_id', auth()->id())->exists();
    }
    public function getRatingAttribute()
    {   
        return $this->users()->where('user_id', auth()->id())->first()->pivot->rating;
    }

    public function ratings()
    {
        return $this->belongsToMany(User::class, 'skill_user')
        ->withPivot('rating', 'created_at')
        ->withTimestamps();
    }
}
