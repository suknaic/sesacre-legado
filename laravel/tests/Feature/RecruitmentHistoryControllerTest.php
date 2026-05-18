<?php

namespace Tests\Feature;

use App\Models\ContractSituation;
use App\Models\EmploymentContract;
use App\Models\JobFunction;
use App\Models\Organization;
use App\Models\RecruitmentHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecruitmentHistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_index_displays_history(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();
        RecruitmentHistory::factory(3)->create([
            'employment_contract_id' => $contract->id,
        ]);

        $response = $this->actingAs($user)->get(route('employment-contracts.recruitment-history.index', $contract));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/RecruitmentHistory/Index')
            ->has('history', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();

        $response = $this->actingAs($user)->get(route('employment-contracts.recruitment-history.create', $contract));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/RecruitmentHistory/Create')
            ->has('contractSituations')
            ->has('organizations')
            ->has('jobFunctions')
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();
        $situation = ContractSituation::factory()->create();
        $organization = Organization::factory()->create();
        $function = JobFunction::factory()->create();

        $response = $this->actingAs($user)->post(
            route('employment-contracts.recruitment-history.store', $contract),
            [
                'contract_situation_id' => $situation->id,
                'organization_id' => $organization->id,
                'job_function_id' => $function->id,
                'history_date' => '2024-06-15',
                'start_date' => '2024-06-15',
                'observation' => 'Registro de teste',
            ]
        );

        $response->assertRedirect(route('employment-contracts.recruitment-history.index', $contract));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('recruitment_history', [
            'employment_contract_id' => $contract->id,
            'observation' => 'Registro de teste',
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();

        $response = $this->actingAs($user)->post(
            route('employment-contracts.recruitment-history.store', $contract),
            []
        );

        $response->assertSessionHasErrors(['history_date']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();
        $record = RecruitmentHistory::factory()->create([
            'employment_contract_id' => $contract->id,
        ]);

        $response = $this->actingAs($user)->get(
            route('employment-contracts.recruitment-history.show', [$contract, $record])
        );

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/RecruitmentHistory/Show')
            ->has('recruitmentHistory')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();
        $record = RecruitmentHistory::factory()->create([
            'employment_contract_id' => $contract->id,
        ]);

        $response = $this->actingAs($user)->get(
            route('employment-contracts.recruitment-history.edit', [$contract, $record])
        );

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/RecruitmentHistory/Edit')
            ->has('recruitmentHistory')
            ->has('contractSituations')
            ->has('organizations')
            ->has('jobFunctions')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();
        $record = RecruitmentHistory::factory()->create([
            'employment_contract_id' => $contract->id,
        ]);

        $response = $this->actingAs($user)->put(
            route('employment-contracts.recruitment-history.update', [$contract, $record]),
            [
                'history_date' => '2024-07-01',
                'observation' => 'Observação atualizada',
            ]
        );

        $response->assertRedirect(route('employment-contracts.recruitment-history.index', $contract));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('recruitment_history', [
            'id' => $record->id,
            'observation' => 'Observação atualizada',
        ]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();
        $record = RecruitmentHistory::factory()->create([
            'employment_contract_id' => $contract->id,
        ]);

        $response = $this->actingAs($user)->delete(
            route('employment-contracts.recruitment-history.destroy', [$contract, $record])
        );

        $response->assertRedirect(route('employment-contracts.recruitment-history.index', $contract));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('recruitment_history', ['id' => $record->id]);
    }
}
