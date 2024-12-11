<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EndorsementRequest extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'endorsement_requests';

    protected $fillable = [
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

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime:Y-m-d H:i:s',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'filled_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

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
        return !is_null($this->filled_at);
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

}
