<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiariasPerfilAcessoControllerTest extends TestCase
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

        $response = $this->actingAs($user)->get(route('diarias-perfil-acesso.index'));

        $response->assertOk();
    }

    public function test_update_changes_access(): void
    {
        $admin = User::factory()->create();
        $target = User::factory()->create(['can_access_diarias' => false]);

        $response = $this->actingAs($admin)->put(route('diarias-perfil-acesso.update', $target), [
            'can_access_diarias' => true,
        ]);

        $response->assertRedirect();
        $this->assertTrue($target->fresh()->can_access_diarias);
    }
}
