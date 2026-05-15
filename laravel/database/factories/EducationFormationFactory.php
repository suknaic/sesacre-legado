<?php

namespace Database\Factories;

use App\Models\EducationFormation;
use App\Models\EducationLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFormationFactory extends Factory
{
    protected $model = EducationFormation::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'education_level_id' => EducationLevel::factory(),
            'is_active' => true,
        ];
    }
}
