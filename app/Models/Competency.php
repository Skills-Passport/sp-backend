<?php

namespace App\Models;

use App\Models\Endorsement;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competency extends Model
{
    /** @use HasFactory<\Database\Factories\CompetencyFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'desc', 'overview'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    // protected $translatable = ['title', 'desc', 'overview'];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'competency_profile')->withTimestamps();
    }

    public function getRatingAttribute()
    {
        return $this->skills->avg('rating');
    }

    public function endorsements()
    {
        return $this->hasMany(Endorsement::class);
    }
}
