<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    protected $fillable = ['name', 'guard_name'];

    public const TEACHER = 'teacher';
    public const HEAD_TEACHER = 'head-teacher';
    public const STUDENT = 'student';
    public const ADMIN = 'admin';
    
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'guard_name'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = ['is_teacher', 'is_head_teacher'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getIsTeacherAttribute()
    {
        return in_array($this->name, ['teacher', 'head-teacher']);
    }

    public function getIsHeadTeacherAttribute()
    {
        return $this->name === 'head-teacher';
    }

    protected $table = 'roles';
}
