<?php

namespace Database\Factories;

use App\Models\ConEmpenho;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConEmpenhoFactory extends Factory
{
    protected $model = ConEmpenho::class;

    public function definition(): array
    {
        return [
            'nr_empenho' => fake()->numerify('EMP-####'),
            'dt_empenho_sistema' => fake()->date(),
            'dt_empenho_safira' => fake()->date(),
            'vl_empenho' => fake()->randomFloat(2, 100, 100000),
            'sit_empenho' => 1,
            'ds_empenho' => fake()->optional()->sentence(),
        ];
    }
}
