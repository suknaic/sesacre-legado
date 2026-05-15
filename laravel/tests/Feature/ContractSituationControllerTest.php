<?php

namespace Tests\Feature;

use App\Models\ContractSituation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContractSituationControllerTest extends TestCase
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
        ContractSituation::factory(3)->create();

        $response = $this->actingAs($user)->get(route('contract-situations.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/ContractSituations/Index')
            ->has('contractSituations.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('contract-situations.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('HR/ContractSituations/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('contract-situations.store'), [
            'name' => 'Férias Regulamentares',
            'type' => 'F',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('contract-situations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contract_situations', ['name' => 'Férias Regulamentares', 'type' => 'F']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('contract-situations.store'), []);
        $response->assertSessionHasErrors(['name', 'type']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = ContractSituation::factory()->create();

        $response = $this->actingAs($user)->get(route('contract-situations.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/ContractSituations/Show')
            ->has('contractSituation')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = ContractSituation::factory()->create();

        $response = $this->actingAs($user)->get(route('contract-situations.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/ContractSituations/Edit')
            ->has('contractSituation')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = ContractSituation::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($user)->put(route('contract-situations.update', $record), [
            'name' => 'Updated Name',
            'type' => $record->type,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('contract-situations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contract_situations', ['id' => $record->id, 'name' => 'Updated Name']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = ContractSituation::factory()->create();

        $response = $this->actingAs($user)->delete(route('contract-situations.destroy', $record));

        $response->assertRedirect(route('contract-situations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('contract_situations', ['id' => $record->id]);
    }

}
