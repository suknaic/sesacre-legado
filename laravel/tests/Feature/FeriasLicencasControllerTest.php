<?php

namespace Tests\Feature;

use App\Models\EmploymentContract;
use App\Models\RecruitmentHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeriasLicencasControllerTest extends TestCase
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
        $contract = EmploymentContract::factory()->create();
        RecruitmentHistory::factory(3)->create([
            'employment_contract_id' => $contract->id,
        ]);

        $response = $this->actingAs($user)->get(route('ferias-licencas.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/FeriasLicencas/Index')
            ->has('history.data')
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('ferias-licencas.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/FeriasLicencas/Create')
            ->has('employmentContracts')
            ->has('contractSituations')
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();

        $response = $this->actingAs($user)->post(route('ferias-licencas.store'), [
            'employment_contract_id' => $contract->id,
            'history_date' => '2024-06-15',
            'observation' => 'Férias de teste',
        ]);

        $response->assertRedirect(route('ferias-licencas.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('recruitment_history', [
            'employment_contract_id' => $contract->id,
            'observation' => 'Férias de teste',
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('ferias-licencas.store'), []);

        $response->assertSessionHasErrors(['employment_contract_id', 'history_date']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();
        $record = RecruitmentHistory::factory()->create([
            'employment_contract_id' => $contract->id,
        ]);

        $response = $this->actingAs($user)->get(route('ferias-licencas.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/FeriasLicencas/Show')
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

        $response = $this->actingAs($user)->get(route('ferias-licencas.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/FeriasLicencas/Edit')
            ->has('recruitmentHistory')
            ->has('contractSituations')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $contract = EmploymentContract::factory()->create();
        $record = RecruitmentHistory::factory()->create([
            'employment_contract_id' => $contract->id,
        ]);

        $response = $this->actingAs($user)->put(route('ferias-licencas.update', $record), [
            'history_date' => '2024-07-01',
            'observation' => 'Observação atualizada',
        ]);

        $response->assertRedirect(route('ferias-licencas.index'));
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

        $response = $this->actingAs($user)->delete(route('ferias-licencas.destroy', $record));

        $response->assertRedirect(route('ferias-licencas.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('recruitment_history', ['id' => $record->id]);
    }
}
