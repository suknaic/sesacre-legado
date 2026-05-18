<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasActionIndicator extends Model
{
    use HasFactory;

    protected $fillable = ['annual_plan_id', 'plan_action_id', 'health_indicator_id'];

    public function annualPlan(): BelongsTo
    {
        return $this->belongsTo(AnnualPlan::class);
    }

    public function planAction(): BelongsTo
    {
        return $this->belongsTo(PlanAction::class);
    }

    public function healthIndicator(): BelongsTo
    {
        return $this->belongsTo(HealthIndicator::class);
    }
}
