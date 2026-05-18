<?php

namespace Database\Factories;

use App\Models\ConLiquidacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConLiquidacaoFactory extends Factory
{
    protected $model = ConLiquidacao::class;

    public function definition(): array
    {
        return [
            'nr_liquidacao' => fake()->numerify('LIQ-####'),
            'dt_liquidacao' => fake()->date(),
            'vl_liquidacao' => fake()->randomFloat(2, 100, 100000),
            'vl_liquidacao_saldo' => fake()->randomFloat(2, 0, 50000),
            'st_ativo' => 1,
        ];
    }
}
