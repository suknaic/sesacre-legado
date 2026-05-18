<?php

namespace Tests\Feature;

use App\Models\StrategicPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GovernmentProgramControllerTest extends TestCase
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
        StrategicPlan::factory(3)->create();

        $response = $this->actingAs($user)->get(route('government-programs.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/GovernmentPrograms/Index')
            ->has('programs.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('government-programs.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/GovernmentPrograms/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('government-programs.store'), [
            'name' => 'Programa Saúde para Todos',
            'start_year' => 2024,
            'end_year' => 2027,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('government-programs.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('strategic_plans', ['name' => 'Programa Saúde para Todos']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('government-programs.store'), []);
        $response->assertSessionHasErrors(['name', 'start_year', 'end_year']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = StrategicPlan::factory()->create();

        $response = $this->actingAs($user)->get(route('government-programs.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/GovernmentPrograms/Show')
            ->has('program')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = StrategicPlan::factory()->create();

        $response = $this->actingAs($user)->get(route('government-programs.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/GovernmentPrograms/Edit')
            ->has('program')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = StrategicPlan::factory()->create(['name' => 'Old Program']);

        $response = $this->actingAs($user)->put(route('government-programs.update', $record), [
            'name' => 'Updated Program',
            'start_year' => 2024,
            'end_year' => 2027,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('government-programs.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('strategic_plans', ['id' => $record->id, 'name' => 'Updated Program']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = StrategicPlan::factory()->create();

        $response = $this->actingAs($user)->delete(route('government-programs.destroy', $record));

        $response->assertRedirect(route('government-programs.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('strategic_plans', ['id' => $record->id]);
    }
}
