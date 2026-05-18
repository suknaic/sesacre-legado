<?php

namespace Tests\Feature;

use App\Models\PerDiemRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiariasAutorizacaoControllerTest extends TestCase
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

        $response = $this->actingAs($user)->get(route('diarias-autorizacoes.index'));

        $response->assertOk();
    }

    public function test_approve_advances_stage(): void
    {
        $user = User::factory()->create();
        $request = PerDiemRequest::factory()->create(['stage' => 1]);

        $response = $this->actingAs($user)->post(route('diarias-autorizacoes.approve', $request));

        $response->assertRedirect();
        $this->assertEquals(2, $request->fresh()->stage);
    }

    public function test_approve_at_stage_5_stays_at_5(): void
    {
        $user = User::factory()->create();
        $request = PerDiemRequest::factory()->create(['stage' => 5]);

        $response = $this->actingAs($user)->post(route('diarias-autorizacoes.approve', $request));

        $response->assertRedirect();
        $this->assertEquals(5, $request->fresh()->stage);
    }

    public function test_reject_sets_stage_to_minus_1(): void
    {
        $user = User::factory()->create();
        $request = PerDiemRequest::factory()->create(['stage' => 2]);

        $response = $this->actingAs($user)->post(route('diarias-autorizacoes.reject', $request));

        $response->assertRedirect();
        $this->assertEquals(-1, $request->fresh()->stage);
    }

    public function test_reset_returns_to_stage_1(): void
    {
        $user = User::factory()->create();
        $request = PerDiemRequest::factory()->create(['stage' => -1]);

        $response = $this->actingAs($user)->post(route('diarias-autorizacoes.reset', $request));

        $response->assertRedirect();
        $this->assertEquals(1, $request->fresh()->stage);
    }
}
