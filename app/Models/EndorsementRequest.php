<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EndorsementRequest extends Model
{
    /** @use HasFactory<\Database\Factories\EndorsementRequestFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'skill_id', 'created_by', 'sent_to_email', 'is_approved', 'data', 'approved_by', 'approved_at'];

    protected $casts = [
        'data' => 'array',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $hidden = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
