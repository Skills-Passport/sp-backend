<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = ['name', 'desc', 'created_by', 'closed_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_members')->withTimestamps();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'group_skills')->withTimestamps();
    }
}
