<?php

namespace Tests\Feature;

use App\Models\AnnualPlan;
use App\Models\PasAction;
use App\Models\PlanAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasActionControllerTest extends TestCase
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
        PasAction::factory(3)->create();

        $response = $this->actingAs($user)->get(route('pas-actions.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PasActions/Index')
            ->has('pasActions.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('pas-actions.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/PasActions/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $annualPlan = AnnualPlan::factory()->create();
        $planAction = PlanAction::factory()->create();

        $response = $this->actingAs($user)->post(route('pas-actions.store'), [
            'annual_plan_id' => $annualPlan->id,
            'plan_action_id' => $planAction->id,
            'programming_goal' => 'Reduzir em 20%',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('pas-actions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pas_actions', ['programming_goal' => 'Reduzir em 20%']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('pas-actions.store'), []);
        $response->assertSessionHasErrors(['annual_plan_id', 'plan_action_id']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PasAction::factory()->create();

        $response = $this->actingAs($user)->get(route('pas-actions.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PasActions/Show')
            ->has('pasAction')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PasAction::factory()->create();

        $response = $this->actingAs($user)->get(route('pas-actions.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PasActions/Edit')
            ->has('pasAction')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $annualPlan = AnnualPlan::factory()->create();
        $planAction = PlanAction::factory()->create();
        $record = PasAction::factory()->create();

        $response = $this->actingAs($user)->put(route('pas-actions.update', $record), [
            'annual_plan_id' => $annualPlan->id,
            'plan_action_id' => $planAction->id,
            'programming_goal' => 'Updated Goal',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('pas-actions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pas_actions', ['id' => $record->id, 'programming_goal' => 'Updated Goal']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PasAction::factory()->create();

        $response = $this->actingAs($user)->delete(route('pas-actions.destroy', $record));

        $response->assertRedirect(route('pas-actions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('pas_actions', ['id' => $record->id]);
    }
}
