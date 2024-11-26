<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ratings';

    protected $fillable = ['user_id', 'skill_id', 'previous_rating', 'new_rating', 'approved_at', 'approved_by'];

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

    public function approve(User $user)
    {
        $this->approved_at = now();
        $this->approved_by = $user->id;
        $this->save();
    }
}
