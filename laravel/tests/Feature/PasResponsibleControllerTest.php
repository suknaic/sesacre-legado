<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\PasResponsible;
use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasResponsibleControllerTest extends TestCase
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
        PasResponsible::factory(3)->create();

        $response = $this->actingAs($user)->get(route('pas-responsibles.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PasResponsibles/Index')
            ->has('responsibles.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('pas-responsibles.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/PasResponsibles/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $person = PersonalInfo::factory()->create();
        $org = Organization::factory()->create();

        $response = $this->actingAs($user)->post(route('pas-responsibles.store'), [
            'personal_info_id' => $person->id,
            'organization_id' => $org->id,
        ]);

        $response->assertRedirect(route('pas-responsibles.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pas_responsibles', [
            'personal_info_id' => $person->id,
            'organization_id' => $org->id,
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('pas-responsibles.store'), []);
        $response->assertSessionHasErrors(['personal_info_id', 'organization_id']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PasResponsible::factory()->create();

        $response = $this->actingAs($user)->get(route('pas-responsibles.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PasResponsibles/Show')
            ->has('responsible')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PasResponsible::factory()->create();

        $response = $this->actingAs($user)->get(route('pas-responsibles.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PasResponsibles/Edit')
            ->has('responsible')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $person = PersonalInfo::factory()->create();
        $org = Organization::factory()->create();
        $record = PasResponsible::factory()->create();

        $response = $this->actingAs($user)->put(route('pas-responsibles.update', $record), [
            'personal_info_id' => $person->id,
            'organization_id' => $org->id,
        ]);

        $response->assertRedirect(route('pas-responsibles.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pas_responsibles', [
            'id' => $record->id,
            'personal_info_id' => $person->id,
        ]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PasResponsible::factory()->create();

        $response = $this->actingAs($user)->delete(route('pas-responsibles.destroy', $record));

        $response->assertRedirect(route('pas-responsibles.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('pas_responsibles', ['id' => $record->id]);
    }
}
