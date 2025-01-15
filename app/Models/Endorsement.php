<?php

namespace App\Models;

use App\Filters\EndorsementFilter;
use App\Http\Resources\EndorsementResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Endorsement extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'endorsements';

    protected $fillable = [
        'content',
        'title',
        'rating',
        'skill_id',
        'created_by',
        'created_by_email',
        'user_id',
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

    protected $withs = ['skill', 'user', 'profile', 'createdBy'];

    protected static function booted(): void
    {
        static::created(function ($e) {
            Timeline::create([
                'timelineable_id' => $e->id,
                'timelineable_type' => self::class,
                'user_id' => $e->user_id,
                'skill_id' => $e->skill_id,
            ]);
        });
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

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        return (new EndorsementFilter($request))->filter($query);
    }

    public function resource()
    {
        return new EndorsementResource($this);
    }
}
