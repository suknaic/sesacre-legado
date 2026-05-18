<?php

namespace Database\Factories;

use App\Models\AnnualPlan;
use App\Models\PasValidation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasValidationFactory extends Factory
{
    protected $model = PasValidation::class;

    public function definition(): array
    {
        return [
            'annual_plan_id' => AnnualPlan::factory(),
            'validation_status' => fake()->numberBetween(1, 4),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
