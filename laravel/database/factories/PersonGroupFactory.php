<?php

namespace Database\Factories;

use App\Models\PersonGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonGroupFactory extends Factory
{
    protected $model = PersonGroup::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'is_active' => true,
        ];
    }
}
