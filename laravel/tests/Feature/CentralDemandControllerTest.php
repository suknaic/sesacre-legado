<?php

namespace Tests\Feature;

use App\Models\CentralDemand;
use App\Models\Organization;
use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CentralDemandControllerTest extends TestCase
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
        CentralDemand::factory(3)->create();

        $response = $this->actingAs($user)->get(route('central-demands.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/CentralDemands/Index')
            ->has('demands.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('central-demands.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/CentralDemands/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $person = PersonalInfo::factory()->create();
        $org = Organization::factory()->create();

        $response = $this->actingAs($user)->post(route('central-demands.store'), [
            'personal_info_id' => $person->id,
            'organization_id' => $org->id,
        ]);

        $response->assertRedirect(route('central-demands.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('central_demands', [
            'personal_info_id' => $person->id,
            'organization_id' => $org->id,
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('central-demands.store'), []);
        $response->assertSessionHasErrors(['personal_info_id', 'organization_id']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = CentralDemand::factory()->create();

        $response = $this->actingAs($user)->get(route('central-demands.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/CentralDemands/Show')
            ->has('demand')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = CentralDemand::factory()->create();

        $response = $this->actingAs($user)->get(route('central-demands.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/CentralDemands/Edit')
            ->has('demand')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $person = PersonalInfo::factory()->create();
        $org = Organization::factory()->create();
        $record = CentralDemand::factory()->create();

        $response = $this->actingAs($user)->put(route('central-demands.update', $record), [
            'personal_info_id' => $person->id,
            'organization_id' => $org->id,
        ]);

        $response->assertRedirect(route('central-demands.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('central_demands', [
            'id' => $record->id,
            'personal_info_id' => $person->id,
        ]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = CentralDemand::factory()->create();

        $response = $this->actingAs($user)->delete(route('central-demands.destroy', $record));

        $response->assertRedirect(route('central-demands.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('central_demands', ['id' => $record->id]);
    }
}
