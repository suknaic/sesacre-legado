<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commitment extends Model
{
    protected $fillable = [
        'purchase_request_id',
        'person_id',
        'commitment_type_id',
        'number',
        'system_date',
        'external_date',
        'amount',
        'description',
        'situation',
        'commitment_status_id',
        'document_routing_type_id',
        'department_id',
    ];

    protected function casts(): array
    {
        return [
            'system_date' => 'date',
            'external_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(CommitmentType::class, 'commitment_type_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(CommitmentStatus::class, 'commitment_status_id');
    }

    public function history(): HasMany
    {
        return $this->hasMany(CommitmentHistory::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(CommitmentNote::class);
    }
}
