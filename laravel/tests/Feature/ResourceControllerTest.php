<?php

namespace Tests\Feature;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_model_can_be_created_via_factory(): void
    {
        $resource = Resource::factory()->create();
        $this->assertDatabaseHas('resources', ['id' => $resource->id]);
    }

    public function test_index_returns_success(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('resources.index'));
        $response->assertOk();
    }

    public function test_create_returns_success(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('resources.create'));
        $response->assertOk();
    }

    public function test_store_creates_resource(): void
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->make();

        $response = $this->actingAs($user)->post(route('resources.store'), $resource->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('resources.index'));
        $this->assertDatabaseHas('resources', ['name' => $resource->name]);
    }

    public function test_show_returns_success(): void
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();

        $response = $this->actingAs($user)->get(route('resources.show', $resource));
        $response->assertOk();
    }

    public function test_edit_returns_success(): void
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();

        $response = $this->actingAs($user)->get(route('resources.edit', $resource));
        $response->assertOk();
    }

    public function test_update_updates_resource(): void
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();
        $updatedData = Resource::factory()->make();

        $response = $this->actingAs($user)->put(route('resources.update', $resource), $updatedData->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('resources.index'));
        $this->assertDatabaseHas('resources', ['id' => $resource->id, 'name' => $updatedData->name]);
    }

    public function test_destroy_deletes_resource(): void
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();

        $response = $this->actingAs($user)->delete(route('resources.destroy', $resource));

        $response->assertRedirect(route('resources.index'));
        $this->assertDatabaseMissing('resources', ['id' => $resource->id]);
    }
}
