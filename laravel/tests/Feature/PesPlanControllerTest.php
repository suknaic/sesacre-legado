<?php

namespace Tests\Feature;

use App\Models\PesPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PesPlanControllerTest extends TestCase
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
        PesPlan::factory(3)->create();

        $response = $this->actingAs($user)->get(route('pes-plans.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PesPlans/Index')
            ->has('pesPlans.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('pes-plans.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/PesPlans/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pes-plans.store'), [
            'name' => 'PES 2024-2027',
            'start_year' => 2024,
            'end_year' => 2027,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('pes-plans.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pes_plans', ['name' => 'PES 2024-2027']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('pes-plans.store'), []);
        $response->assertSessionHasErrors(['name', 'start_year', 'end_year']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PesPlan::factory()->create();

        $response = $this->actingAs($user)->get(route('pes-plans.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PesPlans/Show')
            ->has('pesPlan')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PesPlan::factory()->create();

        $response = $this->actingAs($user)->get(route('pes-plans.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PesPlans/Edit')
            ->has('pesPlan')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = PesPlan::factory()->create(['name' => 'Old PES']);

        $response = $this->actingAs($user)->put(route('pes-plans.update', $record), [
            'name' => 'Updated PES',
            'start_year' => 2024,
            'end_year' => 2027,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('pes-plans.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pes_plans', ['id' => $record->id, 'name' => 'Updated PES']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PesPlan::factory()->create();

        $response = $this->actingAs($user)->delete(route('pes-plans.destroy', $record));

        $response->assertRedirect(route('pes-plans.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('pes_plans', ['id' => $record->id]);
    }
}
