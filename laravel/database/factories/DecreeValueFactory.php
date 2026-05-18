<?php

namespace Database\Factories;

use App\Models\DecreeType;
use App\Models\DecreeValue;
use App\Models\TravelClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class DecreeValueFactory extends Factory
{
    protected $model = DecreeValue::class;

    public function definition(): array
    {
        return [
            'decree_type_id' => DecreeType::factory(),
            'travel_class_id' => TravelClass::factory(),
            'value' => fake()->randomFloat(2, 50, 2000),
            'is_active' => true,
        ];
    }
}
