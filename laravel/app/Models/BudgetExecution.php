<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetExecution extends Model
{
    use HasFactory;

    protected $fillable = ['budget_proposal_id', 'plan_action_id', 'status', 'executed_amount', 'execution_date', 'notes'];

    protected function casts(): array
    {
        return [
            'executed_amount' => 'decimal:2',
            'execution_date' => 'date',
        ];
    }

    public function budgetProposal(): BelongsTo
    {
        return $this->belongsTo(BudgetProposal::class);
    }

    public function planAction(): BelongsTo
    {
        return $this->belongsTo(PlanAction::class);
    }
}
