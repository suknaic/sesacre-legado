<?php

namespace Tests\Feature;

use App\Models\EducationLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EducationLevelControllerTest extends TestCase
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
        EducationLevel::factory(3)->create();

        $response = $this->actingAs($user)->get(route('education-levels.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EducationLevels/Index')
            ->has('educationLevels.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('education-levels.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('HR/EducationLevels/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('education-levels.store'), [
            'name' => 'Superior',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('education-levels.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('education_levels', ['name' => 'Superior']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('education-levels.store'), []);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = EducationLevel::factory()->create();

        $response = $this->actingAs($user)->get(route('education-levels.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EducationLevels/Show')
            ->has('educationLevel')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = EducationLevel::factory()->create();

        $response = $this->actingAs($user)->get(route('education-levels.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EducationLevels/Edit')
            ->has('educationLevel')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = EducationLevel::factory()->create(['name' => 'Old Level']);

        $response = $this->actingAs($user)->put(route('education-levels.update', $record), [
            'name' => 'Updated Level',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('education-levels.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('education_levels', ['id' => $record->id, 'name' => 'Updated Level']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = EducationLevel::factory()->create();

        $response = $this->actingAs($user)->delete(route('education-levels.destroy', $record));

        $response->assertRedirect(route('education-levels.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('education_levels', ['id' => $record->id]);
    }
}
