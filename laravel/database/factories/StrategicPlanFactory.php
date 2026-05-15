<?php

namespace Database\Factories;

use App\Models\StrategicPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class StrategicPlanFactory extends Factory
{
    protected $model = StrategicPlan::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company().' PPA',
            'start_year' => (string) fake()->numberBetween(2024, 2028),
            'end_year' => (string) fake()->numberBetween(2029, 2034),
            'is_active' => true,
        ];
    }
}
