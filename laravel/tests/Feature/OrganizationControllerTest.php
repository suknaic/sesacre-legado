<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_index_displays_paginated_records(): void
    {
        $user = User::factory()->create();
        Organization::factory(3)->create();

        $response = $this->actingAs($user)->get(route('organizations.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Administration/Organizations/Index')
            ->has('organizations.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('organizations.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Administration/Organizations/Create')
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('organizations.store'), [
            'name' => 'Secretaria de Saúde do Acre',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('organizations.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('organizations', ['name' => 'Secretaria de Saúde do Acre']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('organizations.store'), []);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = Organization::factory()->create();

        $response = $this->actingAs($user)->get(route('organizations.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Administration/Organizations/Show')
            ->has('organization')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = Organization::factory()->create();

        $response = $this->actingAs($user)->get(route('organizations.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Administration/Organizations/Edit')
            ->has('organization')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = Organization::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($user)->put(route('organizations.update', $record), [
            'name' => 'Updated Name',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('organizations.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('organizations', [
            'id' => $record->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = Organization::factory()->create();

        $response = $this->actingAs($user)->delete(route('organizations.destroy', $record));

        $response->assertRedirect(route('organizations.index'));
        $response->assertSessionHas('success');

        $this->assertSoftDeleted($record);
    }
}
