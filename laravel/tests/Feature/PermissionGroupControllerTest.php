<?php

namespace Tests\Feature;

use App\Models\PermissionGroup;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionGroupControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_model_can_be_created_via_factory(): void
    {
        $group = PermissionGroup::factory()->create();
        $this->assertDatabaseHas('permission_groups', ['id' => $group->id]);
    }

    public function test_index_returns_success(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('permission-groups.index'));
        $response->assertOk();
    }

    public function test_create_returns_success(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('permission-groups.create'));
        $response->assertOk();
    }

    public function test_store_creates_permission_group(): void
    {
        $user = User::factory()->create();
        $group = PermissionGroup::factory()->make();

        $response = $this->actingAs($user)->post(route('permission-groups.store'), $group->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('permission-groups.index'));
        $this->assertDatabaseHas('permission_groups', ['name' => $group->name]);
    }

    public function test_store_with_resources(): void
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();

        $response = $this->actingAs($user)->post(route('permission-groups.store'), [
            'name' => 'Test Group',
            'is_active' => true,
            'resources' => [
                ['id' => $resource->id, 'can_create' => true, 'can_edit' => false, 'can_delete' => false],
            ],
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('permission_groups', ['name' => 'Test Group']);
        $this->assertDatabaseHas('permission_group_resource', [
            'permission_group_id' => PermissionGroup::where('name', 'Test Group')->first()->id,
            'resource_id' => $resource->id,
            'can_create' => true,
        ]);
    }

    public function test_show_returns_success(): void
    {
        $user = User::factory()->create();
        $group = PermissionGroup::factory()->create();

        $response = $this->actingAs($user)->get(route('permission-groups.show', $group));
        $response->assertOk();
    }

    public function test_edit_returns_success(): void
    {
        $user = User::factory()->create();
        $group = PermissionGroup::factory()->create();

        $response = $this->actingAs($user)->get(route('permission-groups.edit', $group));
        $response->assertOk();
    }

    public function test_update_updates_permission_group(): void
    {
        $user = User::factory()->create();
        $group = PermissionGroup::factory()->create();
        $updatedData = PermissionGroup::factory()->make();

        $response = $this->actingAs($user)->put(route('permission-groups.update', $group), $updatedData->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('permission-groups.index'));
        $this->assertDatabaseHas('permission_groups', ['id' => $group->id, 'name' => $updatedData->name]);
    }

    public function test_destroy_deletes_permission_group(): void
    {
        $user = User::factory()->create();
        $group = PermissionGroup::factory()->create();

        $response = $this->actingAs($user)->delete(route('permission-groups.destroy', $group));

        $response->assertRedirect(route('permission-groups.index'));
        $this->assertDatabaseMissing('permission_groups', ['id' => $group->id]);
    }
}
