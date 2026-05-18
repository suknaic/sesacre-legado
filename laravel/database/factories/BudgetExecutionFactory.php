<?php

namespace Database\Factories;

use App\Models\BudgetExecution;
use App\Models\BudgetProposal;
use App\Models\PlanAction;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetExecutionFactory extends Factory
{
    protected $model = BudgetExecution::class;

    public function definition(): array
    {
        return [
            'budget_proposal_id' => BudgetProposal::factory(),
            'plan_action_id' => PlanAction::factory(),
            'status' => fake()->randomElement(['not_started', 'in_progress', 'partially_completed', 'completed']),
            'executed_amount' => fake()->randomFloat(2, 0, 1000000),
            'execution_date' => fake()->date(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
