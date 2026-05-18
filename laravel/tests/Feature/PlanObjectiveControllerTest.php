<?php

namespace Tests\Feature;

use App\Models\PlanObjective;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanObjectiveControllerTest extends TestCase
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
        PlanObjective::factory(3)->create();

        $response = $this->actingAs($user)->get(route('plan-objectives.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanObjectives/Index')
            ->has('planObjectives.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('plan-objectives.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/PlanObjectives/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('plan-objectives.store'), [
            'name' => 'Reduzir mortalidade infantil',
            'indicator' => 'Taxa de mortalidade',
            'goal' => 'Reduzir em 20%',
            'registration_type' => 'PPA',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('plan-objectives.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('plan_objectives', ['name' => 'Reduzir mortalidade infantil']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('plan-objectives.store'), []);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanObjective::factory()->create();

        $response = $this->actingAs($user)->get(route('plan-objectives.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanObjectives/Show')
            ->has('planObjective')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PlanObjective::factory()->create();

        $response = $this->actingAs($user)->get(route('plan-objectives.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanObjectives/Edit')
            ->has('planObjective')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanObjective::factory()->create(['name' => 'Old Objective']);

        $response = $this->actingAs($user)->put(route('plan-objectives.update', $record), [
            'name' => 'Updated Objective',
            'indicator' => 'New Indicator',
            'goal' => 'New Goal',
            'registration_type' => 'PES',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('plan-objectives.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('plan_objectives', ['id' => $record->id, 'name' => 'Updated Objective']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanObjective::factory()->create();

        $response = $this->actingAs($user)->delete(route('plan-objectives.destroy', $record));

        $response->assertRedirect(route('plan-objectives.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('plan_objectives', ['id' => $record->id]);
    }
}
