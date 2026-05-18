<?php

namespace Tests\Feature;

use App\Models\PerDiemRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiariasRelatorioControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_index_returns_success(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('diarias-relatorios.index'));

        $response->assertOk();
    }

    public function test_gerar_returns_results(): void
    {
        $user = User::factory()->create();
        PerDiemRequest::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('diarias-relatorios.gerar', [
            'date_from' => now()->subMonth()->format('Y-m-d'),
            'date_to' => now()->addMonth()->format('Y-m-d'),
        ]));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Diarias/Relatorios/Index'));
    }

    public function test_gerar_with_filters(): void
    {
        $user = User::factory()->create();
        $req = PerDiemRequest::factory()->create(['stage' => 1]);

        $response = $this->actingAs($user)->get(route('diarias-relatorios.gerar', [
            'stage' => 1,
        ]));

        $response->assertOk();
    }
}
