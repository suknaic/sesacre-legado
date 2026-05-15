<?php

namespace Tests\Feature;

use App\Models\EducationFormation;
use App\Models\EducationLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EducationFormationControllerTest extends TestCase
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
        EducationFormation::factory(3)->create();

        $response = $this->actingAs($user)->get(route('education-formations.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EducationFormations/Index')
            ->has('educationFormations.data', 3)
        );
    }

    public function test_create_displays_the_form_with_education_levels(): void
    {
        $user = User::factory()->create();
        EducationLevel::factory(2)->create();

        $response = $this->actingAs($user)->get(route('education-formations.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EducationFormations/Create')
            ->has('educationLevels', 2)
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::factory()->create();

        $response = $this->actingAs($user)->post(route('education-formations.store'), [
            'name' => 'Medicina',
            'education_level_id' => $level->id,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('education-formations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('education_formations', [
            'name' => 'Medicina',
            'education_level_id' => $level->id,
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('education-formations.store'), []);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record_with_education_level(): void
    {
        $user = User::factory()->create();
        $record = EducationFormation::factory()->create();

        $response = $this->actingAs($user)->get(route('education-formations.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EducationFormations/Show')
            ->has('educationFormation')
        );
    }

    public function test_edit_displays_the_form_with_education_levels(): void
    {
        $user = User::factory()->create();
        $record = EducationFormation::factory()->create();

        $response = $this->actingAs($user)->get(route('education-formations.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EducationFormations/Edit')
            ->has('educationFormation')
            ->has('educationLevels')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::factory()->create();
        $record = EducationFormation::factory()->create(['name' => 'Old Formation']);

        $response = $this->actingAs($user)->put(route('education-formations.update', $record), [
            'name' => 'Updated Formation',
            'education_level_id' => $level->id,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('education-formations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('education_formations', ['id' => $record->id, 'name' => 'Updated Formation']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = EducationFormation::factory()->create();

        $response = $this->actingAs($user)->delete(route('education-formations.destroy', $record));

        $response->assertRedirect(route('education-formations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('education_formations', ['id' => $record->id]);
    }
}
