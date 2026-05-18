<?php

namespace Database\Factories;

use App\Models\ConPagamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConPagamentoFactory extends Factory
{
    protected $model = ConPagamento::class;

    public function definition(): array
    {
        return [
            'nr_pagamento' => fake()->numerify('PAG-####'),
            'dt_pagamento' => fake()->date(),
            'vl_pagamento' => fake()->randomFloat(2, 100, 100000),
            'vl_pagamento_saldo' => fake()->randomFloat(2, 0, 50000),
            'st_ativo' => 1,
        ];
    }
}
