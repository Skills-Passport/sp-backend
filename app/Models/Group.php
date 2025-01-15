<?php

namespace App\Models;

use App\Filters\GroupFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Group extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected static function booted(): void
    {
        static::creating(function ($group) {
            if ($group->created_by === null) {
                $group->created_by = auth()->id();
            }
        });
    }

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'desc',
        'archived_at',
        'created_by',
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    protected $withs = ['skills', 'members', 'students', 'teachers'];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'archived_at' => 'datetime',
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

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('archived_at');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id');
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
