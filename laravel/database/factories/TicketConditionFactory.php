<?php

namespace Database\Factories;

use App\Models\TicketCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketConditionFactory extends Factory
{
    protected $model = TicketCondition::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'is_active' => true,
        ];
    }
}
