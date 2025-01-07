<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\Filters\GroupSkillFilter;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, HasUuids, Notifiable, HasPermissions;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'job_title',
        'address',
        'field',
        'personal_coach',
        'first_name',
        'last_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    protected $appends = [
        'role',
    ];

    protected $withs = [
        'skills',
        'groups',
        'personalCoach',
        'feedbacks',
        'endorsements',
        'ratings',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function personalCoach()
    {
        return $this->belongsTo(User::class, 'personal_coach');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'personal_coach');
    }

    public function writtenFeedbacks()
    {
        return $this->hasMany(Feedback::class, 'created_by');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }

    public function endorsements()
    {
        return $this->hasMany(Endorsement::class, 'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function timelines()
    {
        return $this->morphMany(Timeline::class, 'timelineable');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_user', 'user_id', 'skill_id')
            ->withPivot('last_rating');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id')->withPivot('role');
    }

    public function competencies()
    {
        return $this->skills()->with('competency')->get()->pluck('competency')->unique();
    }

    public function feedbackRequests()
    {
        return $this->hasMany(FeedbackRequest::class, 'recipient_id');
    }

    public function endorsementsRequests()
    {
        return $this->hasMany(EndorsementRequest::class, 'recipient_id');
    }

    public function getRoleAttribute()
    {
        return $this->roles->first();
    }

    public function getIsStudentAttribute()
    {
        return $this->hasRole('Student');
    }

    public function getIsEducatorAttribute()
    {
        return $this->hasAnyRole(['Admin', 'Head-teacher', 'Teacher']);
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole('Admin');
    }

    public function getIsHeadTeacherAttribute()
    {
        return $this->hasRole('Head-teacher');
    }

    public function hasPersonalCoach()
    {
        return $this->personal_coach !== null;
    }

    public function scopeFilter(Builder $query, Request $request)
    {
        return (new UserFilter($request))->filter($query);
    }
    public function scopeSkillFilter(Builder $query, Request $request): Builder
    {
        return (new GroupSkillFilter($request))->filter($query);
    }

}
