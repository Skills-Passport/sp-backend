<?php

namespace App\Models;

use App\Http\Resources\RatingResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ratings';

    protected $fillable = ['user_id', 'skill_id', 'new_rating', 'approved_at', 'approved_by'];

    protected $withs = ['user', 'skill', 'approvedBy', 'createdBy'];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function timeline()
    {
        return $this->morphOne(Timeline::class, 'timelineable');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function resource()
    {
        return new RatingResource($this);
    }

    public function approve(User $user)
    {
        $this->approved_at = now();
        $this->approved_by = $user->id;
        $this->save();
    }
}
