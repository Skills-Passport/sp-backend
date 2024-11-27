<?php

namespace App\Models;

use App\Filters\GroupFilter;
use App\Traits\PopulatesIfEmpty;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Group extends Model
{
    use HasFactory, HasUuids, PopulatesIfEmpty, SoftDeletes;

    protected $table = 'groups';

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

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'group_skills', 'group_id', 'skill_id');
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        return (new GroupFilter($request))->filter($query);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id')->wherePivot('role', 'student');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id')->wherePivot('role', 'teacher');
    }
}
