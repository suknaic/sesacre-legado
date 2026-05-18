<?php

namespace Tests\Feature;

use App\Models\PlanningAxis;
use App\Models\PesPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanningAxisControllerTest extends TestCase
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
        PlanningAxis::factory(3)->create();

        $response = $this->actingAs($user)->get(route('planning-axes.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanningAxes/Index')
            ->has('axes.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('planning-axes.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/PlanningAxes/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $pesPlan = PesPlan::factory()->create();

        $response = $this->actingAs($user)->post(route('planning-axes.store'), [
            'pes_plan_id' => $pesPlan->id,
            'name' => 'Eixo Teste',
            'order' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('planning-axes.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('planning_axes', ['name' => 'Eixo Teste']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('planning-axes.store'), []);
        $response->assertSessionHasErrors(['pes_plan_id', 'name', 'order']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanningAxis::factory()->create();

        $response = $this->actingAs($user)->get(route('planning-axes.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanningAxes/Show')
            ->has('axis')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PlanningAxis::factory()->create();

        $response = $this->actingAs($user)->get(route('planning-axes.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanningAxes/Edit')
            ->has('axis')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $pesPlan = PesPlan::factory()->create();
        $record = PlanningAxis::factory()->create(['name' => 'Old Axis']);

        $response = $this->actingAs($user)->put(route('planning-axes.update', $record), [
            'pes_plan_id' => $pesPlan->id,
            'name' => 'Updated Axis',
            'order' => 2,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('planning-axes.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('planning_axes', ['id' => $record->id, 'name' => 'Updated Axis']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanningAxis::factory()->create();

        $response = $this->actingAs($user)->delete(route('planning-axes.destroy', $record));

        $response->assertRedirect(route('planning-axes.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('planning_axes', ['id' => $record->id]);
    }
}
