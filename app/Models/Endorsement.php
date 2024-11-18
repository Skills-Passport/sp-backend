<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Endorsement extends Model
{
    /** @use HasFactory<\Database\Factories\EndorsementFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'skill_id', 'content', 'rating', 'created_by', 'created_by_email', 'is_approved'];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $with = ['user', 'skill'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
