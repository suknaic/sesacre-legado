<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanAction extends Model
{
    protected $fillable = ['plan_objective_id', 'name', 'indicator', 'goal', 'registration_type', 'is_active', 'department_id'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function objective(): BelongsTo
    {
        return $this->belongsTo(PlanObjective::class, 'plan_objective_id');
    }
}
