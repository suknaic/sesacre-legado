<?php

namespace Tests\Feature;

use App\Models\MeasurementUnit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeasurementUnitControllerTest extends TestCase
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
        MeasurementUnit::factory(3)->create();

        $response = $this->actingAs($user)->get(route('measurement-units.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/MeasurementUnits/Index')
            ->has('measurementUnits.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('measurement-units.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/MeasurementUnits/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('measurement-units.store'), [
            'name' => 'Unidade',
        ]);

        $response->assertRedirect(route('measurement-units.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('measurement_units', ['name' => 'Unidade']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('measurement-units.store'), []);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = MeasurementUnit::factory()->create();

        $response = $this->actingAs($user)->get(route('measurement-units.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/MeasurementUnits/Show')
            ->has('measurementUnit')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = MeasurementUnit::factory()->create();

        $response = $this->actingAs($user)->get(route('measurement-units.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/MeasurementUnits/Edit')
            ->has('measurementUnit')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = MeasurementUnit::factory()->create(['name' => 'Old Unit']);

        $response = $this->actingAs($user)->put(route('measurement-units.update', $record), [
            'name' => 'Updated Unit',
        ]);

        $response->assertRedirect(route('measurement-units.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('measurement_units', ['id' => $record->id, 'name' => 'Updated Unit']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = MeasurementUnit::factory()->create();

        $response = $this->actingAs($user)->delete(route('measurement-units.destroy', $record));

        $response->assertRedirect(route('measurement-units.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('measurement_units', ['id' => $record->id]);
    }
}
