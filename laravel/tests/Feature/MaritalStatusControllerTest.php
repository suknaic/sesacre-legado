<?php

namespace Tests\Feature;

use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaritalStatusControllerTest extends TestCase
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
        MaritalStatus::factory(3)->create();

        $response = $this->actingAs($user)->get(route('marital-statuses.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/MaritalStatuses/Index')
            ->has('maritalStatuses.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('marital-statuses.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/MaritalStatuses/Create')
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('marital-statuses.store'), [
            'name' => 'Casado',
        ]);

        $response->assertRedirect(route('marital-statuses.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('marital_statuses', ['name' => 'Casado']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('marital-statuses.store'), []);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = MaritalStatus::factory()->create();

        $response = $this->actingAs($user)->get(route('marital-statuses.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/MaritalStatuses/Show')
            ->has('maritalStatus')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = MaritalStatus::factory()->create();

        $response = $this->actingAs($user)->get(route('marital-statuses.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/MaritalStatuses/Edit')
            ->has('maritalStatus')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = MaritalStatus::factory()->create(['name' => 'Solteiro']);

        $response = $this->actingAs($user)->put(route('marital-statuses.update', $record), [
            'name' => 'Divorciado',
        ]);

        $response->assertRedirect(route('marital-statuses.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('marital_statuses', [
            'id' => $record->id,
            'name' => 'Divorciado',
        ]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = MaritalStatus::factory()->create();

        $response = $this->actingAs($user)->delete(route('marital-statuses.destroy', $record));

        $response->assertRedirect(route('marital-statuses.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('marital_statuses', ['id' => $record->id]);
    }
}
