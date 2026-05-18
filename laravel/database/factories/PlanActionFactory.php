<?php

namespace Database\Factories;

use App\Models\PlanAction;
use App\Models\PlanObjective;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanActionFactory extends Factory
{
    protected $model = PlanAction::class;

    public function definition(): array
    {
        return [
            'plan_objective_id' => PlanObjective::factory(),
            'name' => fake()->sentence(3),
            'indicator' => fake()->sentence(2),
            'goal' => fake()->sentence(),
            'registration_type' => fake()->randomElement(['PPA', 'PES', 'PAS']),
            'is_active' => true,
        ];
    }
}
