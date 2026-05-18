<?php

namespace Tests\Feature;

use App\Models\BudgetExecution;
use App\Models\BudgetProposal;
use App\Models\PlanAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetExecutionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_index_displays_dashboard_with_summary(): void
    {
        $user = User::factory()->create();
        BudgetExecution::factory(3)->create();

        $response = $this->actingAs($user)->get(route('budget-execution.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/BudgetExecutions/Index')
            ->has('executions.data', 3)
            ->has('summary')
            ->has('budgetProposals')
            ->has('planActions')
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('budget-execution.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/BudgetExecutions/Create')
            ->has('budgetProposals')
            ->has('planActions')
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $budgetProposal = BudgetProposal::factory()->create();

        $response = $this->actingAs($user)->post(route('budget-execution.store'), [
            'budget_proposal_id' => $budgetProposal->id,
            'status' => 'in_progress',
            'executed_amount' => 50000.00,
            'execution_date' => '2026-05-18',
            'notes' => 'Teste de execução',
        ]);

        $response->assertRedirect(route('budget-execution.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('budget_executions', [
            'budget_proposal_id' => $budgetProposal->id,
            'executed_amount' => 50000.00,
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('budget-execution.store'), []);

        $response->assertSessionHasErrors(['budget_proposal_id', 'status', 'executed_amount', 'execution_date']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = BudgetExecution::factory()->create();

        $response = $this->actingAs($user)->get(route('budget-execution.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/BudgetExecutions/Show')
            ->has('execution')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = BudgetExecution::factory()->create();

        $response = $this->actingAs($user)->get(route('budget-execution.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/BudgetExecutions/Edit')
            ->has('execution')
            ->has('budgetProposals')
            ->has('planActions')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $budgetProposal = BudgetProposal::factory()->create();
        $record = BudgetExecution::factory()->create(['executed_amount' => 10000]);

        $response = $this->actingAs($user)->put(route('budget-execution.update', $record), [
            'budget_proposal_id' => $budgetProposal->id,
            'status' => 'completed',
            'executed_amount' => 75000.00,
            'execution_date' => '2026-06-01',
            'notes' => 'Atualizado',
        ]);

        $response->assertRedirect(route('budget-execution.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('budget_executions', [
            'id' => $record->id,
            'executed_amount' => 75000.00,
            'status' => 'completed',
        ]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = BudgetExecution::factory()->create();

        $response = $this->actingAs($user)->delete(route('budget-execution.destroy', $record));

        $response->assertRedirect(route('budget-execution.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('budget_executions', ['id' => $record->id]);
    }
}
