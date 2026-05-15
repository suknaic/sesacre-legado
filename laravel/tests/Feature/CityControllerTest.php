<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityControllerTest extends TestCase
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
        City::factory(3)->create();

        $response = $this->actingAs($user)->get(route('cities.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Cities/Index')
            ->has('cities.data', 3)
        );
    }

    public function test_create_displays_the_form_with_states(): void
    {
        $user = User::factory()->create();
        State::factory(2)->create();

        $response = $this->actingAs($user)->get(route('cities.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Cities/Create')
            ->has('states', 2)
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $state = State::factory()->create();

        $response = $this->actingAs($user)->post(route('cities.store'), [
            'state_id' => $state->id,
            'name' => 'Rio Branco',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('cities.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('cities', ['name' => 'Rio Branco', 'state_id' => $state->id]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('cities.store'), []);
        $response->assertSessionHasErrors(['state_id', 'name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = City::factory()->create();

        $response = $this->actingAs($user)->get(route('cities.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Cities/Show')
            ->has('city')
        );
    }

    public function test_edit_displays_the_form_with_states(): void
    {
        $user = User::factory()->create();
        $record = City::factory()->create();

        $response = $this->actingAs($user)->get(route('cities.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Cities/Edit')
            ->has('city')
            ->has('states')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $state = State::factory()->create();
        $record = City::factory()->create(['name' => 'Old City']);

        $response = $this->actingAs($user)->put(route('cities.update', $record), [
            'state_id' => $state->id,
            'name' => 'Updated City',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('cities.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('cities', ['id' => $record->id, 'name' => 'Updated City']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = City::factory()->create();

        $response = $this->actingAs($user)->delete(route('cities.destroy', $record));

        $response->assertRedirect(route('cities.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('cities', ['id' => $record->id]);
    }
}
