<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\System;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RhAccessControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_index_displays_users_with_access_info(): void
    {
        System::factory()->create(['name' => 'RH']);
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('rh-access.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('HR/AccessControl/Index')
            ->has('users.data')
            ->has('rhRoles')
        );
    }

    public function test_update_grants_rh_access(): void
    {
        System::factory()->create(['name' => 'RH']);
        $rhRole = Role::factory()->create([
            'system_id' => System::where('name', 'RH')->first()->id,
            'name' => 'Usuário RH',
        ]);
        $admin = User::factory()->create();
        $targetUser = User::factory()->create();

        $response = $this->actingAs($admin)->put(route('rh-access.update', $targetUser), [
            'role_id' => $rhRole->id,
            'grant' => true,
        ]);

        $response->assertRedirect(route('rh-access.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('role_user', [
            'user_id' => $targetUser->id,
            'role_id' => $rhRole->id,
        ]);
    }

    public function test_update_revokes_rh_access(): void
    {
        System::factory()->create(['name' => 'RH']);
        $rhRole = Role::factory()->create([
            'system_id' => System::where('name', 'RH')->first()->id,
            'name' => 'Usuário RH',
        ]);
        $admin = User::factory()->create();
        $targetUser = User::factory()->create();
        $targetUser->roles()->attach($rhRole->id);

        $response = $this->actingAs($admin)->put(route('rh-access.update', $targetUser), [
            'role_id' => $rhRole->id,
            'grant' => false,
        ]);

        $response->assertRedirect(route('rh-access.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('role_user', [
            'user_id' => $targetUser->id,
            'role_id' => $rhRole->id,
        ]);
    }
}
