<?php

namespace Tests\Feature;

use App\Models\PlanAction;
use App\Models\PlanObjective;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanActionControllerTest extends TestCase
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
        PlanAction::factory(3)->create();

        $response = $this->actingAs($user)->get(route('plan-actions.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanActions/Index')
            ->has('planActions.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        PlanObjective::factory()->create();

        $response = $this->actingAs($user)->get(route('plan-actions.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanActions/Create')
            ->has('objectives')
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $objective = PlanObjective::factory()->create();

        $response = $this->actingAs($user)->post(route('plan-actions.store'), [
            'plan_objective_id' => $objective->id,
            'name' => 'Ampliar cobertura vacinal',
            'indicator' => 'Cobertura vacinal',
            'goal' => 'Alcançar 95%',
            'registration_type' => 'PPA',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('plan-actions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('plan_actions', ['name' => 'Ampliar cobertura vacinal']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('plan-actions.store'), []);
        $response->assertSessionHasErrors(['plan_objective_id', 'name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanAction::factory()->create();

        $response = $this->actingAs($user)->get(route('plan-actions.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanActions/Show')
            ->has('planAction')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PlanAction::factory()->create();

        $response = $this->actingAs($user)->get(route('plan-actions.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanActions/Edit')
            ->has('planAction')
            ->has('objectives')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $objective = PlanObjective::factory()->create();
        $record = PlanAction::factory()->create(['name' => 'Old Action']);

        $response = $this->actingAs($user)->put(route('plan-actions.update', $record), [
            'plan_objective_id' => $objective->id,
            'name' => 'Updated Action',
            'indicator' => 'New Indicator',
            'goal' => 'New Goal',
            'registration_type' => 'PES',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('plan-actions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('plan_actions', ['id' => $record->id, 'name' => 'Updated Action']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanAction::factory()->create();

        $response = $this->actingAs($user)->delete(route('plan-actions.destroy', $record));

        $response->assertRedirect(route('plan-actions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('plan_actions', ['id' => $record->id]);
    }
}
