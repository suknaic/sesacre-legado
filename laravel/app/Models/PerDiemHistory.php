<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerDiemHistory extends Model
{
    protected $fillable = ['per_diem_request_id', 'person_id', 'history_date', 'description'];

    protected function casts(): array
    {
        return ['history_date' => 'datetime'];
    }

    public function perDiemRequest(): BelongsTo
    {
        return $this->belongsTo(PerDiemRequest::class);
    }
}
