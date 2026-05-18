<?php

namespace Tests\Feature;

use App\Models\BudgetSourceRelease;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetSourceReleaseControllerTest extends TestCase
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
        BudgetSourceRelease::factory(3)->create();

        $response = $this->actingAs($user)->get(route('budget-source-releases.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/BudgetSourceReleases/Index')
            ->has('releases.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('budget-source-releases.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/BudgetSourceReleases/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('budget-source-releases.store'), [
            'fonte_id' => 1,
            'year' => 2026,
            'total_amount' => 500000,
        ]);

        $response->assertRedirect(route('budget-source-releases.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('budget_source_releases', ['year' => 2026]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('budget-source-releases.store'), []);
        $response->assertSessionHasErrors(['fonte_id', 'year', 'total_amount']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = BudgetSourceRelease::factory()->create();

        $response = $this->actingAs($user)->get(route('budget-source-releases.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/BudgetSourceReleases/Show')
            ->has('release')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = BudgetSourceRelease::factory()->create();

        $response = $this->actingAs($user)->get(route('budget-source-releases.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/BudgetSourceReleases/Edit')
            ->has('release')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = BudgetSourceRelease::factory()->create(['year' => 2025]);

        $response = $this->actingAs($user)->put(route('budget-source-releases.update', $record), [
            'fonte_id' => 1,
            'year' => 2026,
            'total_amount' => 750000,
        ]);

        $response->assertRedirect(route('budget-source-releases.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('budget_source_releases', ['id' => $record->id, 'year' => 2026]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = BudgetSourceRelease::factory()->create();

        $response = $this->actingAs($user)->delete(route('budget-source-releases.destroy', $record));

        $response->assertRedirect(route('budget-source-releases.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('budget_source_releases', ['id' => $record->id]);
    }
}
