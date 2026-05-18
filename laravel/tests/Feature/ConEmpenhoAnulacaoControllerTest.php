<?php

namespace Tests\Feature;

use App\Models\ConEmpenhoAnulacao;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConEmpenhoAnulacaoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_model_can_be_created_via_factory(): void
    {
        $anulacao = ConEmpenhoAnulacao::factory()->create();

        $this->assertDatabaseHas('con_empenho_anulacao', [
            'id_empenho_anulacao' => $anulacao->id_empenho_anulacao,
        ]);
    }
}
