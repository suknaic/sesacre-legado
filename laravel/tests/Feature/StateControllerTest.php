<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StateControllerTest extends TestCase
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
        State::factory(3)->create();

        $response = $this->actingAs($user)->get(route('states.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/States/Index')
            ->has('states.data', 3)
        );
    }

    public function test_create_displays_the_form_with_countries(): void
    {
        $user = User::factory()->create();
        Country::factory(2)->create();

        $response = $this->actingAs($user)->get(route('states.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/States/Create')
            ->has('countries', 2)
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $country = Country::factory()->create();

        $response = $this->actingAs($user)->post(route('states.store'), [
            'country_id' => $country->id,
            'code' => 'AC',
            'name' => 'Acre',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('states.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('states', ['code' => 'AC', 'name' => 'Acre']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('states.store'), []);
        $response->assertSessionHasErrors(['country_id', 'code', 'name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = State::factory()->create();

        $response = $this->actingAs($user)->get(route('states.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/States/Show')
            ->has('state')
        );
    }

    public function test_edit_displays_the_form_with_countries(): void
    {
        $user = User::factory()->create();
        $record = State::factory()->create();

        $response = $this->actingAs($user)->get(route('states.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/States/Edit')
            ->has('state')
            ->has('countries')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $country = Country::factory()->create();
        $record = State::factory()->create(['name' => 'Old State']);

        $response = $this->actingAs($user)->put(route('states.update', $record), [
            'country_id' => $country->id,
            'code' => $record->code,
            'name' => 'Updated State',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('states.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('states', ['id' => $record->id, 'name' => 'Updated State']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = State::factory()->create();

        $response = $this->actingAs($user)->delete(route('states.destroy', $record));

        $response->assertRedirect(route('states.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('states', ['id' => $record->id]);
    }
}
