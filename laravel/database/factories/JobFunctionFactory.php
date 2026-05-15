<?php

namespace Database\Factories;

use App\Models\JobFunction;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFunctionFactory extends Factory
{
    protected $model = JobFunction::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->jobTitle(),
            'is_active' => true,
        ];
    }
}
