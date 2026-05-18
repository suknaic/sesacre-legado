<?php

namespace Database\Factories;

use App\Models\LegalEntity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LegalEntityFactory extends Factory
{
    protected $model = LegalEntity::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'trade_name' => fake()->company(),
            'cnpj' => fake()->numerify('##.###.###/####-##'),
            'is_active' => true,
        ];
    }
}
