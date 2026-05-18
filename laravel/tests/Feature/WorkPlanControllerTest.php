<?php

namespace Tests\Feature;

use App\Models\AnnualPlan;
use App\Models\User;
use App\Models\WorkPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkPlanControllerTest extends TestCase
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
        WorkPlan::factory(3)->create();

        $response = $this->actingAs($user)->get(route('work-plans.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/WorkPlans/Index')
            ->has('plans.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('work-plans.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/WorkPlans/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $annualPlan = AnnualPlan::factory()->create();

        $response = $this->actingAs($user)->post(route('work-plans.store'), [
            'annual_plan_id' => $annualPlan->id,
            'name' => 'PTA 2026',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('work-plans.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('work_plans', ['name' => 'PTA 2026']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('work-plans.store'), []);
        $response->assertSessionHasErrors(['annual_plan_id', 'name', 'start_date', 'end_date']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = WorkPlan::factory()->create();

        $response = $this->actingAs($user)->get(route('work-plans.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/WorkPlans/Show')
            ->has('plan')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = WorkPlan::factory()->create();

        $response = $this->actingAs($user)->get(route('work-plans.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/WorkPlans/Edit')
            ->has('plan')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $annualPlan = AnnualPlan::factory()->create();
        $record = WorkPlan::factory()->create(['name' => 'Old PTA']);

        $response = $this->actingAs($user)->put(route('work-plans.update', $record), [
            'annual_plan_id' => $annualPlan->id,
            'name' => 'Updated PTA',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('work-plans.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('work_plans', ['id' => $record->id, 'name' => 'Updated PTA']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = WorkPlan::factory()->create();

        $response = $this->actingAs($user)->delete(route('work-plans.destroy', $record));

        $response->assertRedirect(route('work-plans.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('work_plans', ['id' => $record->id]);
    }
}
