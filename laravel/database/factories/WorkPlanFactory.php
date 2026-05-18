<?php

namespace Database\Factories;

use App\Models\AnnualPlan;
use App\Models\WorkPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkPlanFactory extends Factory
{
    protected $model = WorkPlan::class;

    public function definition(): array
    {
        return [
            'annual_plan_id' => AnnualPlan::factory(),
            'name' => fake()->sentence(3),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'is_active' => true,
        ];
    }
}
