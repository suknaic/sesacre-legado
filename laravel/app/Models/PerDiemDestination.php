<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerDiemDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        'per_diem_request_id', 'origin_city_id', 'destination_city_id',
        'start_at', 'end_at', 'transport_id', 'decree_id', 'travel_class_id',
        'has_overnight_stay', 'quantity', 'value',
    ];

    protected function casts(): array
    {
        return ['start_at' => 'datetime', 'end_at' => 'datetime', 'has_overnight_stay' => 'boolean', 'value' => 'decimal:2'];
    }

    public function perDiemRequest(): BelongsTo
    {
        return $this->belongsTo(PerDiemRequest::class);
    }
}
