<?php

namespace Database\Factories;

use App\Models\HealthIndicator;
use Illuminate\Database\Eloquent\Factories\Factory;

class HealthIndicatorFactory extends Factory
{
    protected $model = HealthIndicator::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'year' => fake()->year(),
            'note_code' => fake()->optional()->bothify('??####'),
            'indicator_type' => fake()->optional()->randomElement(['P', 'S', 'E']),
            'goal' => fake()->optional()->sentence(),
            'unit' => fake()->optional()->word(),
        ];
    }
}
