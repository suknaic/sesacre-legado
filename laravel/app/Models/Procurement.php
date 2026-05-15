<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Procurement extends Model
{
    protected $fillable = [
        'ada_code',
        'auction_code',
        'estimated_total',
        'adjudicated_total',
        'process_date',
        'procurement_object_id',
        'procurement_modality_id',
        'procurement_situation_id',
        'year',
        'technical_manager',
        'spending_type_id',
        'area_id',
        'user_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'process_date' => 'date',
            'estimated_total' => 'decimal:2',
            'adjudicated_total' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function modality(): BelongsTo
    {
        return $this->belongsTo(ProcurementModality::class, 'procurement_modality_id');
    }

    public function object(): BelongsTo
    {
        return $this->belongsTo(ProcurementObject::class, 'procurement_object_id');
    }

    public function situation(): BelongsTo
    {
        return $this->belongsTo(ProcurementSituation::class, 'procurement_situation_id');
    }
}
