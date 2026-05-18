<?php

namespace Tests\Feature;

use App\Models\DeliveryOrder;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryOrderControllerTest extends TestCase
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
        DeliveryOrder::factory(3)->create();

        $response = $this->actingAs($user)->get(route('delivery-orders.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/DeliveryOrders/Index')
            ->has('orders.data', 3)
        );
    }

    public function test_create_displays_the_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('delivery-orders.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Planning/DeliveryOrders/Create'));
    }

    public function test_store_creates_a_new_record(): void
    {
        $user = User::factory()->create();
        $org = Organization::factory()->create();

        $response = $this->actingAs($user)->post(route('delivery-orders.store'), [
            'order_date' => '2026-05-18',
            'material_description' => 'Material de teste',
            'quantity_ordered' => 100,
            'organization_id' => $org->id,
        ]);

        $response->assertRedirect(route('delivery-orders.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('delivery_orders', ['material_description' => 'Material de teste']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('delivery-orders.store'), []);
        $response->assertSessionHasErrors(['order_date', 'material_description', 'quantity_ordered', 'organization_id']);
    }

    public function test_show_displays_a_record(): void
    {
        $user = User::factory()->create();
        $record = DeliveryOrder::factory()->create();

        $response = $this->actingAs($user)->get(route('delivery-orders.show', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/DeliveryOrders/Show')
            ->has('order')
        );
    }

    public function test_edit_displays_the_form(): void
    {
        $user = User::factory()->create();
        $record = DeliveryOrder::factory()->create();

        $response = $this->actingAs($user)->get(route('delivery-orders.edit', $record));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Planning/DeliveryOrders/Edit')
            ->has('order')
        );
    }

    public function test_update_modifies_a_record(): void
    {
        $user = User::factory()->create();
        $org = Organization::factory()->create();
        $record = DeliveryOrder::factory()->create();

        $response = $this->actingAs($user)->put(route('delivery-orders.update', $record), [
            'order_date' => '2026-06-01',
            'material_description' => 'Updated Material',
            'quantity_ordered' => 200,
            'quantity_received' => 50,
            'organization_id' => $org->id,
            'status' => 'partially_received',
        ]);

        $response->assertRedirect(route('delivery-orders.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('delivery_orders', ['id' => $record->id, 'material_description' => 'Updated Material']);
    }

    public function test_destroy_removes_a_record(): void
    {
        $user = User::factory()->create();
        $record = DeliveryOrder::factory()->create();

        $response = $this->actingAs($user)->delete(route('delivery-orders.destroy', $record));

        $response->assertRedirect(route('delivery-orders.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('delivery_orders', ['id' => $record->id]);
    }

    public function test_receive_updates_status(): void
    {
        $user = User::factory()->create();
        $record = DeliveryOrder::factory()->create(['quantity_ordered' => 100, 'quantity_received' => 0]);

        $response = $this->actingAs($user)->post(route('delivery-orders.receive', $record), [
            'quantity_received' => 100,
            'receipt_date' => '2026-06-15',
        ]);

        $response->assertRedirect(route('delivery-orders.show', $record));
        $this->assertDatabaseHas('delivery_orders', [
            'id' => $record->id,
            'quantity_received' => 100,
            'status' => 'received',
        ]);
    }
}
