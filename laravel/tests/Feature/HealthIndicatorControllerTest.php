<?php

namespace Tests\Feature;

use App\Models\HealthIndicator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthIndicatorControllerTest extends TestCase
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
        HealthIndicator::factory(3)->create();

        $response = $this->actingAs($user)->get(route('health-indicators.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/HealthIndicators/Index')
            ->has('indicators.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('health-indicators.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/HealthIndicators/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('health-indicators.store'), [
            'name' => 'Taxa de Mortalidade',
            'year' => 2026,
            'indicator_type' => 'E',
            'goal' => 'Reduzir em 10%',
        ]);

        $response->assertRedirect(route('health-indicators.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('health_indicators', ['name' => 'Taxa de Mortalidade']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('health-indicators.store'), []);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = HealthIndicator::factory()->create();

        $response = $this->actingAs($user)->get(route('health-indicators.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/HealthIndicators/Show')
            ->has('indicator')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = HealthIndicator::factory()->create();

        $response = $this->actingAs($user)->get(route('health-indicators.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/HealthIndicators/Edit')
            ->has('indicator')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $record = HealthIndicator::factory()->create(['name' => 'Old Indicator']);

        $response = $this->actingAs($user)->put(route('health-indicators.update', $record), [
            'name' => 'Updated Indicator',
            'year' => 2026,
        ]);

        $response->assertRedirect(route('health-indicators.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('health_indicators', ['id' => $record->id, 'name' => 'Updated Indicator']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = HealthIndicator::factory()->create();

        $response = $this->actingAs($user)->delete(route('health-indicators.destroy', $record));

        $response->assertRedirect(route('health-indicators.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('health_indicators', ['id' => $record->id]);
    }
}
