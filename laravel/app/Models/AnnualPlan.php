<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnualPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'strategic_plan_id', 'department_id', 'name', 'start_date', 'end_date',
        'responsible_person_id', 'executor_person_id', 'observations', 'situation', 'is_active',
    ];

    protected function casts(): array
    {
        return ['start_date' => 'date', 'end_date' => 'date', 'is_active' => 'boolean'];
    }

    public function strategicPlan(): BelongsTo
    {
        return $this->belongsTo(StrategicPlan::class);
    }
}
