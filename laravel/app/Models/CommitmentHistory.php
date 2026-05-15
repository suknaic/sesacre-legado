<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommitmentHistory extends Model
{
    protected $fillable = [
        'commitment_id',
        'person_id',
        'department_id',
        'document_routing_type_id',
        'commitment_situation_id',
        'commitment_status_id',
        'history_date',
        'description',
    ];

    protected function casts(): array
    {
        return ['history_date' => 'datetime'];
    }

    public function commitment(): BelongsTo
    {
        return $this->belongsTo(Commitment::class);
    }

    public function situation(): BelongsTo
    {
        return $this->belongsTo(CommitmentSituation::class, 'commitment_situation_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(CommitmentStatus::class, 'commitment_status_id');
    }
}
