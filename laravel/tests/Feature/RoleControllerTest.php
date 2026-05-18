<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_model_can_be_created_via_factory(): void
    {
        $role = Role::factory()->create();
        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }

    public function test_index_returns_success(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('roles.index'));
        $response->assertOk();
    }

    public function test_create_returns_success(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('roles.create'));
        $response->assertOk();
    }

    public function test_store_creates_role(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->make();

        $response = $this->actingAs($user)->post(route('roles.store'), $role->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('roles', ['name' => $role->name]);
    }

    public function test_show_returns_success(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAs($user)->get(route('roles.show', $role));
        $response->assertOk();
    }

    public function test_edit_returns_success(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAs($user)->get(route('roles.edit', $role));
        $response->assertOk();
    }

    public function test_update_updates_role(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $updatedData = Role::factory()->make();

        $response = $this->actingAs($user)->put(route('roles.update', $role), $updatedData->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => $updatedData->name]);
    }

    public function test_destroy_deletes_role(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAs($user)->delete(route('roles.destroy', $role));

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
