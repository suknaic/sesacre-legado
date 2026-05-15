<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateFactory extends Factory
{
    protected $model = State::class;

    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'code' => fake()->unique()->stateAbbr(),
            'name' => fake()->unique()->state(),
            'is_active' => true,
        ];
    }
}
