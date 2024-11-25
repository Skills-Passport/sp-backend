<?php

namespace App\Models;

use App\Models\Skill;
use App\Models\Profile;

use App\Traits\PopulatesIfEmpty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Endorsement extends Model
{
    use HasFactory, HasUuids, SoftDeletes, PopulatesIfEmpty;

    protected $table = 'endorsements';

    protected $fillable = [
        'content',
        'rating',
        'is_approved',
        'skill_id',
        'created_by',
        'created_by_email',
        'user_id',
        'approved_at',
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
            'approved_at' => 'datetime',
        ];
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function profile()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}