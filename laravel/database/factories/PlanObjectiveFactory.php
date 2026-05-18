<?php

namespace Database\Factories;

use App\Models\PlanObjective;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanObjectiveFactory extends Factory
{
    protected $model = PlanObjective::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'indicator' => fake()->sentence(2),
            'goal' => fake()->sentence(),
            'registration_type' => fake()->randomElement(['PPA', 'PES', 'PAS']),
            'is_active' => true,
        ];
    }
}
