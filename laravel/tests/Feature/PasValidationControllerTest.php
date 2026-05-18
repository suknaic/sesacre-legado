<?php

namespace Tests\Feature;

use App\Models\AnnualPlan;
use App\Models\PasValidation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasValidationControllerTest extends TestCase
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
        PasValidation::factory(3)->create();

        $response = $this->actingAs($user)->get(route('pas-validations.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PasValidations/Index')
            ->has('validations.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('pas-validations.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/PasValidations/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $annualPlan = AnnualPlan::factory()->create();

        $response = $this->actingAs($user)->post(route('pas-validations.store'), [
            'annual_plan_id' => $annualPlan->id,
            'validation_status' => 2,
            'description' => 'PAS enviado para análise',
        ]);

        $response->assertRedirect(route('pas-validations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pas_validations', ['description' => 'PAS enviado para análise']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('pas-validations.store'), []);
        $response->assertSessionHasErrors(['annual_plan_id', 'validation_status']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PasValidation::factory()->create();

        $response = $this->actingAs($user)->get(route('pas-validations.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PasValidations/Show')
            ->has('validation')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PasValidation::factory()->create();

        $response = $this->actingAs($user)->get(route('pas-validations.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PasValidations/Edit')
            ->has('validation')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $annualPlan = AnnualPlan::factory()->create();
        $record = PasValidation::factory()->create(['validation_status' => 1]);

        $response = $this->actingAs($user)->put(route('pas-validations.update', $record), [
            'annual_plan_id' => $annualPlan->id,
            'validation_status' => 4,
            'description' => 'PAS autorizado',
        ]);

        $response->assertRedirect(route('pas-validations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pas_validations', ['id' => $record->id, 'validation_status' => 4]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PasValidation::factory()->create();

        $response = $this->actingAs($user)->delete(route('pas-validations.destroy', $record));

        $response->assertRedirect(route('pas-validations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('pas_validations', ['id' => $record->id]);
    }
}
