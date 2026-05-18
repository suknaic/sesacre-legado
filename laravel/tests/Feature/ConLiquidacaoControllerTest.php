<?php

namespace Tests\Feature;

use App\Models\ConLiquidacao;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConLiquidacaoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_model_can_be_created_via_factory(): void
    {
        $liquidacao = ConLiquidacao::factory()->create();

        $this->assertDatabaseHas('con_liquidacao', [
            'id_liquidacao' => $liquidacao->id_liquidacao,
        ]);
    }
}
