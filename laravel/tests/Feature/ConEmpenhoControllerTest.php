<?php

namespace Tests\Feature;

use App\Models\ConEmpenho;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConEmpenhoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_model_can_be_created_via_factory(): void
    {
        $empenho = ConEmpenho::factory()->create();

        $this->assertDatabaseHas('fin_empenho', [
            'id_empenho' => $empenho->id_empenho,
        ]);
    }
}
