<?php

namespace Tests\Feature;

use App\Models\OrganizationDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationDetailControllerTest extends TestCase
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
        OrganizationDetail::factory(3)->create();

        $response = $this->actingAs($user)->get(route('organization-details.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/OrganizationDetails/Index')
            ->has('details.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('organization-details.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/OrganizationDetails/Create')
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('organization-details.store'), [
            'name' => 'Departamento de TI',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('organization-details.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('organization_details', ['name' => 'Departamento de TI']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('organization-details.store'), []);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = OrganizationDetail::factory()->create();

        $response = $this->actingAs($user)->get(route('organization-details.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/OrganizationDetails/Show')
            ->has('organizationDetail')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = OrganizationDetail::factory()->create();

        $response = $this->actingAs($user)->get(route('organization-details.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/OrganizationDetails/Edit')
            ->has('organizationDetail')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = OrganizationDetail::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($user)->put(route('organization-details.update', $record), [
            'name' => 'Updated Name',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('organization-details.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('organization_details', [
            'id' => $record->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = OrganizationDetail::factory()->create();

        $response = $this->actingAs($user)->delete(route('organization-details.destroy', $record));

        $response->assertRedirect(route('organization-details.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('organization_details', ['id' => $record->id]);
    }
}
