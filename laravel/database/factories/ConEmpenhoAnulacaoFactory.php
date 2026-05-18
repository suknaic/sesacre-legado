<?php

namespace Database\Factories;

use App\Models\ConEmpenhoAnulacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConEmpenhoAnulacaoFactory extends Factory
{
    protected $model = ConEmpenhoAnulacao::class;

    public function definition(): array
    {
        return [
            'nr_empenho_anulacao' => fake()->numerify('ANUL-####'),
            'dt_empenho_anulacao' => fake()->date(),
            'vl_empenho_anulacao' => fake()->randomFloat(2, 100, 50000),
            'vl_empenho_antigo' => fake()->randomFloat(2, 1000, 100000),
            'vl_empenho_saldo' => fake()->randomFloat(2, 0, 50000),
        ];
    }
}
