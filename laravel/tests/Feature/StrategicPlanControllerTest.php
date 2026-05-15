<?php

namespace Tests\Feature;

use App\Models\StrategicPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StrategicPlanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_index_displays_paginated_plans(): void
    {
        $user = User::factory()->create();
        StrategicPlan::factory(3)->create();

        $response = $this->actingAs($user)->get(route('strategic-plans.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/StrategicPlans/Index')
            ->has('strategicPlans.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('strategic-plans.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/StrategicPlans/Create')
        );
    }

    public function test_store_creates_a_new_plan(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('strategic-plans.store'), [
            'name' => 'PPA 2026-2029',
            'start_year' => '2026',
            'end_year' => '2029',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('strategic-plans.index'));
        $response->assertSessionHas('success', 'PPA criado com sucesso.');

        $this->assertDatabaseHas('strategic_plans', [
            'name' => 'PPA 2026-2029',
            'start_year' => '2026',
            'end_year' => '2029',
            'is_active' => true,
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('strategic-plans.store'), []);

        $response->assertSessionHasErrors(['name', 'start_year', 'end_year']);
    }

    public function test_store_validates_end_year_gte_start_year(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('strategic-plans.store'), [
            'name' => 'Invalid PPA',
            'start_year' => '2030',
            'end_year' => '2025',
        ]);

        $response->assertSessionHasErrors(['end_year']);
    }

    public function test_show_displays_a_plan(): void
    {
        $user = User::factory()->create();
        $plan = StrategicPlan::factory()->create();

        $response = $this->actingAs($user)->get(route('strategic-plans.show', $plan));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/StrategicPlans/Show')
            ->has('strategicPlan')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $plan = StrategicPlan::factory()->create();

        $response = $this->actingAs($user)->get(route('strategic-plans.edit', $plan));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/StrategicPlans/Edit')
            ->has('strategicPlan')
        );
    }

    public function test_update_modifies_a_plan(): void
    {
        $user = User::factory()->create();
        $plan = StrategicPlan::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($user)->put(route('strategic-plans.update', $plan), [
            'name' => 'Updated Name',
            'start_year' => $plan->start_year,
            'end_year' => $plan->end_year,
            'is_active' => $plan->is_active,
        ]);

        $response->assertRedirect(route('strategic-plans.index'));
        $response->assertSessionHas('success', 'PPA atualizado com sucesso.');

        $this->assertDatabaseHas('strategic_plans', [
            'id' => $plan->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_destroy_removes_a_plan(): void
    {
        $user = User::factory()->create();
        $plan = StrategicPlan::factory()->create();

        $response = $this->actingAs($user)->delete(route('strategic-plans.destroy', $plan));

        $response->assertRedirect(route('strategic-plans.index'));
        $response->assertSessionHas('success', 'PPA removido com sucesso.');

        $this->assertDatabaseMissing('strategic_plans', ['id' => $plan->id]);
    }
}
