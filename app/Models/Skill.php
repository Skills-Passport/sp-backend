<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    /** @use HasFactory<\Database\Factories\SkillFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'desc', 'competency_id'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $with = ['competency'];

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_skills')->withPivot('rating', 'is_approved');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_skills')->withTimestamps();
    }
}
