<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerDiemRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_type_id', 'transport_type_id', 'decree_type_id', 'travel_class_id',
        'applicant_person_id', 'applicant_role_id', 'applicant_department_id',
        'proposed_person_id', 'proposed_role_id', 'proposed_department_id',
        'service_description', 'locations', 'notes', 'creation_date', 'requested_at',
        'requester_person_id', 'requester_department_id', 'requester_center_id',
        'has_return', 'purchase_request_id', 'parent_per_diem_id', 'report_id',
        'stage', 'is_active', 'protocol_number',
    ];

    protected function casts(): array
    {
        return [
            'creation_date' => 'date',
            'requested_at' => 'datetime',
            'has_return' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function travelType(): BelongsTo
    {
        return $this->belongsTo(TravelType::class);
    }

    public function transportType(): BelongsTo
    {
        return $this->belongsTo(TransportType::class);
    }

    public function decreeType(): BelongsTo
    {
        return $this->belongsTo(DecreeType::class);
    }

    public function travelClass(): BelongsTo
    {
        return $this->belongsTo(TravelClass::class);
    }

    public function destinations(): HasMany
    {
        return $this->hasMany(PerDiemDestination::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(PerDiemHistory::class);
    }
}
