<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommitmentNote extends Model
{
    protected $fillable = [
        'commitment_id',
        'person_id',
        'note',
        'note_date',
    ];

    protected function casts(): array
    {
        return ['note_date' => 'datetime'];
    }

    public function commitment(): BelongsTo
    {
        return $this->belongsTo(Commitment::class);
    }
}
