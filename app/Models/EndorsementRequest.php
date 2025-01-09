<?php

namespace App\Models;

use App\Filters\EndorsementRequestFilter;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EndorsementRequest extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'endorsement_requests';

    protected $fillable = [
        'title',
        'requester_id',
        'requestee_id',
        'skill_id',
        'requestee_email',
        'data',
        'filled_at',
        'status',
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    protected $withs = ['requester', 'requestee', 'skill'];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime:Y-m-d H:i:s',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'filled_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public const STATUS_APPROVED = 'approved';

    public const STATUS_PENDING = 'pending';

    public const STATUS_FILLED = 'filled';

    public const STATUS_REJECTED = 'rejected';

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function requestee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requestee_id');
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function isFilled(): bool
    {
        return ! is_null($this->filled_at);
    }

    public function fulfill(array $data): self
    {
        $this->update([
            'data' => $data,
            'filled_at' => now(),
            'status' => 'filled',
        ]);

        return $this;
    }

    public function respond(array $data): Endorsement
    {
        $endorsement = Endorsement::create($data);

        $this->update([
            'status' => $this::STATUS_APPROVED,
        ]);

        Rating::create([
            'rating' => $data['rating'],
            'skill_id' => $data['skill_id'],
            'user_id' => $data['user_id'],
            'new_rating' => $data['rating'],
            'approved_at' => now(),
        ]);

        return $endorsement;
    }

    public function approve(): Endorsement
    {

        $data = [
            'title' => $this->title,
            'user_id' => $this->requester_id,
            'skill_id' => $this->skill_id,
            'rating' => $this->data['rating'],
            'created_by_email' => $this->requestee_email,
            'content' => $this->data['feedback'],
        ];

        $endorsement = Endorsement::create($data);

        $this->update([
            'status' => $this::STATUS_APPROVED,
        ]);

        Rating::create([
            'rating' => $data['rating'],
            'skill_id' => $data['skill_id'],
            'user_id' => $data['user_id'],
            'new_rating' => $data['rating'],
            'approved_at' => now(),
        ]);

        return $endorsement;
    }

    public function scopeFilter($query, $request)
    {
        return (new EndorsementRequestFilter($request))->filter($query);
    }
}
