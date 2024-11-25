<?php

namespace App\Models;

use App\Models\Skill;
use App\Models\Profile;
use App\Traits\PopulatesIfEmpty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competency extends Model
{
    use HasFactory, HasUuids, SoftDeletes, PopulatesIfEmpty;

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
}
