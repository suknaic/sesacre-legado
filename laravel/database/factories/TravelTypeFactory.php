<?php

namespace Database\Factories;

use App\Models\TravelType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelTypeFactory extends Factory
{
    protected $model = TravelType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
        ];
    }
}
