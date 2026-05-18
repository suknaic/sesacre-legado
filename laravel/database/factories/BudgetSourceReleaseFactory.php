<?php

namespace Database\Factories;

use App\Models\BudgetSourceRelease;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetSourceReleaseFactory extends Factory
{
    protected $model = BudgetSourceRelease::class;

    public function definition(): array
    {
        return [
            'fonte_id' => 1,
            'year' => fake()->year(),
            'total_amount' => fake()->randomFloat(2, 0, 10000000),
        ];
    }
}
