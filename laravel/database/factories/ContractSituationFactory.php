<?php

namespace Database\Factories;

use App\Models\ContractSituation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractSituationFactory extends Factory
{
    protected $model = ContractSituation::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'type' => fake()->randomElement(['F', 'L', 'C', 'A', 'I']),
            'is_active' => true,
        ];
    }
}
