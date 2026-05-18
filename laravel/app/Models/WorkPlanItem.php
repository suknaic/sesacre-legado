<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkPlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_plan_id', 'material_description', 'quantity',
        'unit_value', 'total_value', 'status', 'notes',
    ];

    public function workPlan(): BelongsTo
    {
        return $this->belongsTo(WorkPlan::class);
    }
}
