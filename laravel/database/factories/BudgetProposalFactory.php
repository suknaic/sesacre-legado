<?php

namespace Database\Factories;

use App\Models\BudgetProposal;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetProposalFactory extends Factory
{
    protected $model = BudgetProposal::class;

    public function definition(): array
    {
        return [
            'year' => fake()->year(),
            'situation' => fake()->numberBetween(1, 3),
            'is_active' => true,
        ];
    }
}
