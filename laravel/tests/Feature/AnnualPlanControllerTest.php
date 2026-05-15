<?php

namespace Tests\Feature;

use App\Models\AnnualPlan;
use App\Models\StrategicPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnualPlanControllerTest extends TestCase
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
        $strategicPlan = StrategicPlan::factory()->create();
        AnnualPlan::factory(3)->create(['strategic_plan_id' => $strategicPlan->id]);

        $response = $this->actingAs($user)->get(route('annual-plans.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/AnnualPlans/Index')
            ->has('annualPlans.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        StrategicPlan::factory(2)->create(['is_active' => true]);

        $response = $this->actingAs($user)->get(route('annual-plans.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/AnnualPlans/Create')
            ->has('strategicPlans', 2)
        );
    }

    public function test_store_creates_a_new_plan(): void
    {
        $user = User::factory()->create();
        $strategicPlan = StrategicPlan::factory()->create();

        $response = $this->actingAs($user)->post(route('annual-plans.store'), [
            'name' => 'Plano Anual 2026',
            'strategic_plan_id' => $strategicPlan->id,
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('annual-plans.index'));
        $response->assertSessionHas('success', 'Plano anual criado com sucesso.');

        $this->assertDatabaseHas('annual_plans', [
            'name' => 'Plano Anual 2026',
            'strategic_plan_id' => $strategicPlan->id,
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('annual-plans.store'), []);

        $response->assertSessionHasErrors(['name', 'strategic_plan_id']);
    }

    public function test_show_displays_a_plan(): void
    {
        $user = User::factory()->create();
        $strategicPlan = StrategicPlan::factory()->create();
        $annualPlan = AnnualPlan::factory()->create([
            'strategic_plan_id' => $strategicPlan->id,
        ]);

        $response = $this->actingAs($user)->get(route('annual-plans.show', $annualPlan));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/AnnualPlans/Show')
            ->has('annualPlan')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $strategicPlan = StrategicPlan::factory()->create();
        $annualPlan = AnnualPlan::factory()->create([
            'strategic_plan_id' => $strategicPlan->id,
        ]);

        $response = $this->actingAs($user)->get(route('annual-plans.edit', $annualPlan));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/AnnualPlans/Edit')
            ->has('annualPlan')
            ->has('strategicPlans')
        );
    }

    public function test_update_modifies_a_plan(): void
    {
        $user = User::factory()->create();
        $strategicPlan = StrategicPlan::factory()->create();
        $annualPlan = AnnualPlan::factory()->create([
            'strategic_plan_id' => $strategicPlan->id,
            'name' => 'Old Name',
        ]);

        $response = $this->actingAs($user)->put(route('annual-plans.update', $annualPlan), [
            'name' => 'Updated Name',
            'strategic_plan_id' => $strategicPlan->id,
            'start_date' => $annualPlan->start_date,
            'end_date' => $annualPlan->end_date,
            'is_active' => $annualPlan->is_active,
        ]);

        $response->assertRedirect(route('annual-plans.index'));
        $response->assertSessionHas('success', 'Plano anual atualizado com sucesso.');

        $this->assertDatabaseHas('annual_plans', [
            'id' => $annualPlan->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_destroy_removes_a_plan(): void
    {
        $user = User::factory()->create();
        $annualPlan = AnnualPlan::factory()->create();

        $response = $this->actingAs($user)->delete(route('annual-plans.destroy', $annualPlan));

        $response->assertRedirect(route('annual-plans.index'));
        $response->assertSessionHas('success', 'Plano anual removido com sucesso.');

        $this->assertDatabaseMissing('annual_plans', ['id' => $annualPlan->id]);
    }
}
