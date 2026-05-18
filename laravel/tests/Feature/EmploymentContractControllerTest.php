<?php

namespace Tests\Feature;

use App\Models\EmploymentBond;
use App\Models\EmploymentContract;
use App\Models\JobPosition;
use App\Models\LegalEntity;
use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmploymentContractControllerTest extends TestCase
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
        EmploymentContract::factory(3)->create();

        $response = $this->actingAs($user)->get(route('employment-contracts.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EmploymentContracts/Index')
            ->has('employmentContracts.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('employment-contracts.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EmploymentContracts/Create')
            ->has('employmentBonds')
            ->has('jobPositions')
            ->has('legalEntities')
            ->has('organizations')
            ->has('jobFunctions')
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $personalInfo = PersonalInfo::factory()->create();
        $bond = EmploymentBond::factory()->create();
        $position = JobPosition::factory()->create();
        $entity = LegalEntity::factory()->create();

        $response = $this->actingAs($user)->post(route('employment-contracts.store'), [
            'personal_info_id' => $personalInfo->id,
            'employment_bond_id' => $bond->id,
            'job_position_id' => $position->id,
            'legal_entity_id' => $entity->id,
            'admission_date' => '2024-01-15',
            'workload' => 40,
        ]);

        $response->assertRedirect(route('employment-contracts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('employment_contracts', [
            'personal_info_id' => $personalInfo->id,
            'workload' => 40,
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('employment-contracts.store'), []);

        $response->assertSessionHasErrors(['personal_info_id', 'admission_date', 'workload']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = EmploymentContract::factory()->create();

        $response = $this->actingAs($user)->get(route('employment-contracts.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EmploymentContracts/Show')
            ->has('employmentContract')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = EmploymentContract::factory()->create();

        $response = $this->actingAs($user)->get(route('employment-contracts.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/EmploymentContracts/Edit')
            ->has('employmentContract')
            ->has('employmentBonds')
            ->has('jobPositions')
            ->has('legalEntities')
            ->has('organizations')
            ->has('jobFunctions')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = EmploymentContract::factory()->create();
        $newPersonalInfo = PersonalInfo::factory()->create();

        $response = $this->actingAs($user)->put(route('employment-contracts.update', $record), [
            'personal_info_id' => $newPersonalInfo->id,
            'admission_date' => '2024-06-01',
            'workload' => 30,
        ]);

        $response->assertRedirect(route('employment-contracts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('employment_contracts', [
            'id' => $record->id,
            'personal_info_id' => $newPersonalInfo->id,
            'workload' => 30,
        ]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = EmploymentContract::factory()->create();

        $response = $this->actingAs($user)->delete(route('employment-contracts.destroy', $record));

        $response->assertRedirect(route('employment-contracts.index'));
        $response->assertSessionHas('success');

        $this->assertSoftDeleted($record);
    }
}
