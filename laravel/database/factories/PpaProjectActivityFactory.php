<?php

namespace Database\Factories;

use App\Models\PpaProjectActivity;
use App\Models\StrategicPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PpaProjectActivityFactory extends Factory
{
    protected $model = PpaProjectActivity::class;

    public function definition(): array
    {
        return [
            'strategic_plan_id' => StrategicPlan::factory(),
            'code' => fake()->unique()->bothify('PROJ###'),
            'name' => fake()->sentence(3),
            'type' => fake()->randomElement(['P', 'A']),
            'is_active' => true,
        ];
    }
}
