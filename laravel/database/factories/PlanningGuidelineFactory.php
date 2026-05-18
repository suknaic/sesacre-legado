<?php

namespace Database\Factories;

use App\Models\PlanningAxis;
use App\Models\PlanningGuideline;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanningGuidelineFactory extends Factory
{
    protected $model = PlanningGuideline::class;

    public function definition(): array
    {
        return [
            'planning_axis_id' => PlanningAxis::factory(),
            'name' => fake()->sentence(3),
            'order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
