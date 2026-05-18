<?php

namespace Database\Factories;

use App\Models\DecreeType;
use Illuminate\Database\Eloquent\Factories\Factory;

class DecreeTypeFactory extends Factory
{
    protected $model = DecreeType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'is_active' => true,
        ];
    }
}
