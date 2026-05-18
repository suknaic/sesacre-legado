<?php

namespace Tests\Feature;

use App\Models\MaritalStatus;
use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonalInfoControllerTest extends TestCase
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
        PersonalInfo::factory(3)->create();

        $response = $this->actingAs($user)->get(route('personal-info.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/PersonalInfo/Index')
            ->has('personalInfos.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('personal-info.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/PersonalInfo/Create')
            ->has('maritalStatuses')
            ->has('educationFormations')
            ->has('states')
        );
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        MaritalStatus::factory()->create(['name' => 'Solteiro(a)']);

        $response = $this->actingAs($user)->post(route('personal-info.store'), [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'cpf' => '52998224725',
            'gender' => 'M',
            'marital_status_id' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('personal_info', ['gender' => 'M']);
        $this->assertDatabaseHas('users', ['name' => 'João Silva', 'cpf' => '52998224725']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('personal-info.store'), []);

        $response->assertSessionHasErrors(['name', 'cpf']);
    }

    public function test_store_validates_invalid_cpf(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('personal-info.store'), [
            'name' => 'João Silva',
            'cpf' => '12345678901',
        ]);

        $response->assertSessionHasErrors(['cpf']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PersonalInfo::factory()->create();

        $response = $this->actingAs($user)->get(route('personal-info.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/PersonalInfo/Show')
            ->has('personalInfo')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PersonalInfo::factory()->create();

        $response = $this->actingAs($user)->get(route('personal-info.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/PersonalInfo/Edit')
            ->has('personalInfo')
            ->has('maritalStatuses')
            ->has('educationFormations')
            ->has('states')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = PersonalInfo::factory()->create();

        $response = $this->actingAs($user)->put(route('personal-info.update', $record), [
            'name' => $record->user->name,
            'cpf' => '52998224725',
            'gender' => 'F',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('personal_info', [
            'id' => $record->id,
            'gender' => 'F',
        ]);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PersonalInfo::factory()->create();

        $response = $this->actingAs($user)->delete(route('personal-info.destroy', $record));

        $response->assertRedirect(route('personal-info.index'));
        $response->assertSessionHas('success');

        $this->assertSoftDeleted($record);
    }
}
