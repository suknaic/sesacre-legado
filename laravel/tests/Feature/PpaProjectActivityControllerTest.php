<?php

namespace Tests\Feature;

use App\Models\PpaProjectActivity;
use App\Models\StrategicPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PpaProjectActivityControllerTest extends TestCase
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
        PpaProjectActivity::factory(3)->create();

        $response = $this->actingAs($user)->get(route('ppa-project-activities.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PpaProjectActivities/Index')
            ->has('items.data', 3)
            ->has('strategicPlans')
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        StrategicPlan::factory()->create();

        $response = $this->actingAs($user)->get(route('ppa-project-activities.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PpaProjectActivities/Create')
            ->has('strategicPlans')
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $plan = StrategicPlan::factory()->create();

        $response = $this->actingAs($user)->post(route('ppa-project-activities.store'), [
            'strategic_plan_id' => $plan->id,
            'code' => 'PROJ001',
            'name' => 'Construção de Hospital',
            'type' => 'P',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('ppa-project-activities.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('ppa_project_activities', ['code' => 'PROJ001']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('ppa-project-activities.store'), []);
        $response->assertSessionHasErrors(['strategic_plan_id', 'code', 'name', 'type']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PpaProjectActivity::factory()->create();

        $response = $this->actingAs($user)->get(route('ppa-project-activities.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PpaProjectActivities/Show')
            ->has('ppaProjectActivity')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PpaProjectActivity::factory()->create();

        $response = $this->actingAs($user)->get(route('ppa-project-activities.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PpaProjectActivities/Edit')
            ->has('ppaProjectActivity')
            ->has('strategicPlans')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $plan = StrategicPlan::factory()->create();
        $record = PpaProjectActivity::factory()->create(['name' => 'Old']);

        $response = $this->actingAs($user)->put(route('ppa-project-activities.update', $record), [
            'strategic_plan_id' => $plan->id,
            'code' => 'NEW001',
            'name' => 'Updated',
            'type' => 'A',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('ppa-project-activities.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('ppa_project_activities', ['id' => $record->id, 'name' => 'Updated']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PpaProjectActivity::factory()->create();

        $response = $this->actingAs($user)->delete(route('ppa-project-activities.destroy', $record));

        $response->assertRedirect(route('ppa-project-activities.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('ppa_project_activities', ['id' => $record->id]);
    }
}
