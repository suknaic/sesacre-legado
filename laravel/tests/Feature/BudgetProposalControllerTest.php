<?php

namespace Tests\Feature;

use App\Models\BudgetProposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetProposalControllerTest extends TestCase
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
        BudgetProposal::factory(3)->create();

        $response = $this->actingAs($user)->get(route('budget-proposals.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/BudgetProposals/Index')
            ->has('budgetProposals.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('budget-proposals.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/BudgetProposals/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('budget-proposals.store'), [
            'year' => 2026,
            'situation' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('budget-proposals.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('budget_proposals', ['year' => 2026]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('budget-proposals.store'), []);
        $response->assertSessionHasErrors(['year']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = BudgetProposal::factory()->create();

        $response = $this->actingAs($user)->get(route('budget-proposals.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/BudgetProposals/Show')
            ->has('budgetProposal')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = BudgetProposal::factory()->create();

        $response = $this->actingAs($user)->get(route('budget-proposals.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/BudgetProposals/Edit')
            ->has('budgetProposal')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = BudgetProposal::factory()->create(['year' => 2025]);

        $response = $this->actingAs($user)->put(route('budget-proposals.update', $record), [
            'year' => 2026,
            'situation' => 2,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('budget-proposals.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('budget_proposals', ['id' => $record->id, 'year' => 2026]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = BudgetProposal::factory()->create();

        $response = $this->actingAs($user)->delete(route('budget-proposals.destroy', $record));

        $response->assertRedirect(route('budget-proposals.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('budget_proposals', ['id' => $record->id]);
    }
}
