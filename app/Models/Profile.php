<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $withs = ['createdBy', 'competencies'];

    protected static function booted(): void
    {
        static::creating(function ($profile) {
            if ($profile->created_by === null) {
                $profile->created_by = auth()->id();
            }
        });
    }

    protected $fillable = [
        'title',
        'desc',
        'created_by',
        'icon',
        'color',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function competencies()
    {
        return $this->belongsToMany(Competency::class, 'competency_profile', 'profile_id', 'competency_id');
    }
}
