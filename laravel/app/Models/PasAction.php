<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'annual_plan_id', 'plan_action_id', 'ppa_project_activity_id',
        'partnership_desc', 'programming_goal', 'programming_indicator', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function annualPlan(): BelongsTo
    {
        return $this->belongsTo(AnnualPlan::class);
    }

    public function planAction(): BelongsTo
    {
        return $this->belongsTo(PlanAction::class);
    }

    public function ppaProjectActivity(): BelongsTo
    {
        return $this->belongsTo(PpaProjectActivity::class);
    }
}
