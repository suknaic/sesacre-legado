<?php

namespace Tests\Feature;

use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobPositionControllerTest extends TestCase
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
        JobPosition::factory(3)->create();

        $response = $this->actingAs($user)->get(route('job-positions.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/JobPositions/Index')
            ->has('jobPositions.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('job-positions.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('HR/JobPositions/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('job-positions.store'), [
            'name' => 'Analista',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('job-positions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('job_positions', ['name' => 'Analista']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('job-positions.store'), []);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = JobPosition::factory()->create();

        $response = $this->actingAs($user)->get(route('job-positions.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/JobPositions/Show')
            ->has('jobPosition')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = JobPosition::factory()->create();

        $response = $this->actingAs($user)->get(route('job-positions.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/JobPositions/Edit')
            ->has('jobPosition')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = JobPosition::factory()->create(['name' => 'Old Position']);

        $response = $this->actingAs($user)->put(route('job-positions.update', $record), [
            'name' => 'Updated Position',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('job-positions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('job_positions', ['id' => $record->id, 'name' => 'Updated Position']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = JobPosition::factory()->create();

        $response = $this->actingAs($user)->delete(route('job-positions.destroy', $record));

        $response->assertRedirect(route('job-positions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('job_positions', ['id' => $record->id]);
    }
}
