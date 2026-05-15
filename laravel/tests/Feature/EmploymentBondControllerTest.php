<?php

namespace Tests\Feature;

use App\Models\EmploymentBond;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmploymentBondControllerTest extends TestCase
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
        EmploymentBond::factory(3)->create();

        $response = $this->actingAs($user)->get(route('employment-bonds.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EmploymentBonds/Index')
            ->has('employmentBonds.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('employment-bonds.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('HR/EmploymentBonds/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('employment-bonds.store'), [
            'name' => 'CLT',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('employment-bonds.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('employment_bonds', ['name' => 'CLT']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('employment-bonds.store'), []);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = EmploymentBond::factory()->create();

        $response = $this->actingAs($user)->get(route('employment-bonds.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EmploymentBonds/Show')
            ->has('employmentBond')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = EmploymentBond::factory()->create();

        $response = $this->actingAs($user)->get(route('employment-bonds.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EmploymentBonds/Edit')
            ->has('employmentBond')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = EmploymentBond::factory()->create(['name' => 'Old Bond']);

        $response = $this->actingAs($user)->put(route('employment-bonds.update', $record), [
            'name' => 'Updated Bond',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('employment-bonds.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('employment_bonds', ['id' => $record->id, 'name' => 'Updated Bond']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = EmploymentBond::factory()->create();

        $response = $this->actingAs($user)->delete(route('employment-bonds.destroy', $record));

        $response->assertRedirect(route('employment-bonds.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('employment_bonds', ['id' => $record->id]);
    }
}
