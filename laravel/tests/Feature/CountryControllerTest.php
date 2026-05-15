<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryControllerTest extends TestCase
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
        Country::factory(3)->create();

        $response = $this->actingAs($user)->get(route('countries.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Countries/Index')
            ->has('countries.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('countries.create'));
        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('HR/Countries/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('countries.store'), [
            'code' => 'BR',
            'name' => 'Brasil',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('countries.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('countries', ['code' => 'BR', 'name' => 'Brasil']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('countries.store'), []);
        $response->assertSessionHasErrors(['code', 'name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = Country::factory()->create();

        $response = $this->actingAs($user)->get(route('countries.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Countries/Show')
            ->has('country')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = Country::factory()->create();

        $response = $this->actingAs($user)->get(route('countries.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/Countries/Edit')
            ->has('country')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = Country::factory()->create(['name' => 'Old Country']);

        $response = $this->actingAs($user)->put(route('countries.update', $record), [
            'code' => $record->code,
            'name' => 'Updated Country',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('countries.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('countries', ['id' => $record->id, 'name' => 'Updated Country']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = Country::factory()->create();

        $response = $this->actingAs($user)->delete(route('countries.destroy', $record));

        $response->assertRedirect(route('countries.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('countries', ['id' => $record->id]);
    }
}
