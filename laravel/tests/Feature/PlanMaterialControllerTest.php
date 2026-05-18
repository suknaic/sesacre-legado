<?php

namespace Tests\Feature;

use App\Models\PlanMaterial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanMaterialControllerTest extends TestCase
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
        PlanMaterial::factory(3)->create();

        $response = $this->actingAs($user)->get(route('plan-materials.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanMaterials/Index')
            ->has('planMaterials.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('plan-materials.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/PlanMaterials/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('plan-materials.store'), [
            'code' => 'MAT001',
            'name' => 'Paracetamol',
            'group_code' => 'GRP01',
            'group_name' => 'Medicamentos',
            'material_type' => 'Consumo',
        ]);

        $response->assertRedirect(route('plan-materials.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('plan_materials', ['code' => 'MAT001']);
    }

    public function test_store_with_only_name(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('plan-materials.store'), [
            'name' => 'Only Name',
        ]);
        $response->assertRedirect(route('plan-materials.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('plan_materials', ['name' => 'Only Name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanMaterial::factory()->create();

        $response = $this->actingAs($user)->get(route('plan-materials.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanMaterials/Show')
            ->has('planMaterial')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = PlanMaterial::factory()->create();

        $response = $this->actingAs($user)->get(route('plan-materials.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/PlanMaterials/Edit')
            ->has('planMaterial')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanMaterial::factory()->create(['code' => 'OLD001']);

        $response = $this->actingAs($user)->put(route('plan-materials.update', $record), [
            'code' => 'NEW001',
            'name' => 'Updated Material',
        ]);

        $response->assertRedirect(route('plan-materials.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('plan_materials', ['id' => $record->id, 'code' => 'NEW001']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = PlanMaterial::factory()->create();

        $response = $this->actingAs($user)->delete(route('plan-materials.destroy', $record));

        $response->assertRedirect(route('plan-materials.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('plan_materials', ['id' => $record->id]);
    }
}
