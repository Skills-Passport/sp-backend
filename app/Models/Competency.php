<?php

namespace App\Models;

use App\Filters\CompetenciesFilter;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Competency extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'competencies';

    protected $fillable = [
        'title',
        'desc',
        'overview',
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'competency_profile', 'competency_id', 'profile_id');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function timeline()
    {
        return $this->morphOne(Timeline::class, 'timelineable');
    }

    public function getRatingAttribute()
    {
        return $this->skills->map(function ($skill) {
            return $skill->rating;
        })->avg();
    }

    public function scopeWithUserSkills($query, $userId)
    {
        return $query->whereHas('skills.users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['skills' => function ($query) use ($userId) {
            $query->whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            });
        }]);
    }

    public function loadUserSkills($userId)
    {
        return $this->load([
            'skills' => function ($query) use ($userId) {
                $query->whereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            },
        ]);
    }

    public function getFeedbacksCountAttribute()
    {
        return $this->skills->map(function ($skill) {
            return $skill->feedbacks_count;
        })->sum();
    }

    public function getEndosementsCountAttribute()
    {
        return $this->skills->map(function ($skill) {
            return $skill->endorsements_count;
        })->sum();
    }

    public function scopeFilter($query, $request)
    {
        return (new CompetenciesFilter($request))->filter($query);
    }
}
