<?php

namespace Tests\Feature;

use App\Models\PlanningGuideline;
use App\Models\PlanningAxis;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanningGuidelineControllerTest extends TestCase
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
        PlanningGuideline::factory(3)->create();

        $response = $this->actingAs($user)->get(route('planning-guidelines.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanningGuidelines/Index')
            ->has('guidelines.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('planning-guidelines.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/PlanningGuidelines/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $axis = PlanningAxis::factory()->create();

        $response = $this->actingAs($user)->post(route('planning-guidelines.store'), [
            'planning_axis_id' => $axis->id,
            'name' => 'Diretriz Teste',
            'order' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('planning-guidelines.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('planning_guidelines', ['name' => 'Diretriz Teste']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('planning-guidelines.store'), []);
        $response->assertSessionHasErrors(['planning_axis_id', 'name', 'order']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanningGuideline::factory()->create();

        $response = $this->actingAs($user)->get(route('planning-guidelines.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanningGuidelines/Show')
            ->has('guideline')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PlanningGuideline::factory()->create();

        $response = $this->actingAs($user)->get(route('planning-guidelines.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanningGuidelines/Edit')
            ->has('guideline')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $axis = PlanningAxis::factory()->create();
        $record = PlanningGuideline::factory()->create(['name' => 'Old Guideline']);

        $response = $this->actingAs($user)->put(route('planning-guidelines.update', $record), [
            'planning_axis_id' => $axis->id,
            'name' => 'Updated Guideline',
            'order' => 2,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('planning-guidelines.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('planning_guidelines', ['id' => $record->id, 'name' => 'Updated Guideline']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanningGuideline::factory()->create();

        $response = $this->actingAs($user)->delete(route('planning-guidelines.destroy', $record));

        $response->assertRedirect(route('planning-guidelines.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('planning_guidelines', ['id' => $record->id]);
    }
}
