<?php

namespace Tests\Feature;

use App\Models\JobFunction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobFunctionControllerTest extends TestCase
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
        JobFunction::factory(3)->create();

        $response = $this->actingAs($user)->get(route('job-functions.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/JobFunctions/Index')
            ->has('jobFunctions.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('job-functions.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('HR/JobFunctions/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('job-functions.store'), [
            'name' => 'Médico',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('job-functions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('job_functions', ['name' => 'Médico']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('job-functions.store'), []);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = JobFunction::factory()->create();

        $response = $this->actingAs($user)->get(route('job-functions.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/JobFunctions/Show')
            ->has('jobFunction')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = JobFunction::factory()->create();

        $response = $this->actingAs($user)->get(route('job-functions.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/JobFunctions/Edit')
            ->has('jobFunction')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = JobFunction::factory()->create(['name' => 'Old Function']);

        $response = $this->actingAs($user)->put(route('job-functions.update', $record), [
            'name' => 'Updated Function',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('job-functions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('job_functions', ['id' => $record->id, 'name' => 'Updated Function']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = JobFunction::factory()->create();

        $response = $this->actingAs($user)->delete(route('job-functions.destroy', $record));

        $response->assertRedirect(route('job-functions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('job_functions', ['id' => $record->id]);
    }
}
