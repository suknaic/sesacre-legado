<?php

namespace Database\Factories;

use App\Models\AnnualPlan;
use App\Models\StrategicPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnualPlanFactory extends Factory
{
    protected $model = AnnualPlan::class;

    public function definition(): array
    {
        $start = fake()->date();

        return [
            'strategic_plan_id' => StrategicPlan::factory(),
            'name' => fake()->sentence(3),
            'start_date' => $start,
            'end_date' => fake()->dateTimeBetween($start, '+1 year')->format('Y-m-d'),
            'is_active' => true,
        ];
    }
}
