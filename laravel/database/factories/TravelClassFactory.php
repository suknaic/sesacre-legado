<?php

namespace Database\Factories;

use App\Models\TravelClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelClassFactory extends Factory
{
    protected $model = TravelClass::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'code' => fake()->unique()->lexify('???'),
            'is_active' => true,
        ];
    }
}
