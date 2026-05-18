<?php

namespace Database\Factories;

use App\Models\PesPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesPlanFactory extends Factory
{
    protected $model = PesPlan::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company().' PES',
            'start_year' => fake()->numberBetween(2020, 2024),
            'end_year' => fn (array $attrs) => $attrs['start_year'] + fake()->numberBetween(3, 5),
            'is_active' => true,
        ];
    }
}
