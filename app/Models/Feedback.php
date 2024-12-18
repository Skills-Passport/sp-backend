<?php

namespace App\Models;

use App\Traits\PopulatesIfEmpty;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\FeedbackResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    /** @use HasFactory<\Database\Factories\FeedbackFactory> */
    use HasFactory, HasUuids, PopulatesIfEmpty, SoftDeletes;

    protected $table = 'feedbacks';
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
    protected $fillable = [
        'title',
        'content',
        'skill_id',
        'user_id',
        'created_by',
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function timeline()
    {
        return $this->morphOne(Timeline::class, 'timelineable');
    }
    public function resource()
    {
        return new FeedbackResource($this);
    }
}
