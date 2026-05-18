<?php

namespace Tests\Feature;

use App\Models\ConPagamento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConPagamentoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_model_can_be_created_via_factory(): void
    {
        $pagamento = ConPagamento::factory()->create();

        $this->assertDatabaseHas('con_pagamento', [
            'id_pagamento' => $pagamento->id_pagamento,
        ]);
    }
}
