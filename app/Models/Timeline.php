<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timeline extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'timeline';

    protected $fillable = [
        'timelineable_id',
        'timelineable_type',
        'user_id',
        'skill_id',
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

    public function timelineable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
