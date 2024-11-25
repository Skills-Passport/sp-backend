<?php

namespace App\Models;

use App\Models\Skill;
use App\Models\Profile;
use App\Traits\PopulatesIfEmpty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory, HasUuids, SoftDeletes, PopulatesIfEmpty;

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
        return $this->hasMany(Skill::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id');
    }
}