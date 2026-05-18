<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiariasCentralResponsavelControllerTest extends TestCase
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

        $response = $this->actingAs($user)->get(route('diarias-central-responsavel.index'));

        $response->assertOk();
    }

    public function test_toggle_changes_is_active(): void
    {
        $user = User::factory()->create();
        $org = Organization::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->post(route('diarias-central-responsavel.toggle', $org));

        $response->assertRedirect();
        $this->assertFalse($org->fresh()->is_active);
    }
}
