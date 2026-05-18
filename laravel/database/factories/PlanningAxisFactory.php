<?php

namespace Database\Factories;

use App\Models\PlanningAxis;
use App\Models\PesPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanningAxisFactory extends Factory
{
    protected $model = PlanningAxis::class;

    public function definition(): array
    {
        return [
            'pes_plan_id' => PesPlan::factory(),
            'name' => fake()->sentence(2),
            'order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
