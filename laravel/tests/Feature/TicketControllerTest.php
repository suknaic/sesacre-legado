<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_model_can_be_created_via_factory(): void
    {
        $ticket = Ticket::factory()->create();

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
        ]);
    }

    public function test_index_returns_success(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tickets.index'));

        $response->assertOk();
    }

    public function test_create_returns_success(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tickets.create'));

        $response->assertOk();
    }

    public function test_store_creates_ticket(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->make();

        $response = $this->actingAs($user)->post(route('tickets.store'), $ticket->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tickets.index'));
        $this->assertDatabaseHas('tickets', [
            'description' => $ticket->description,
        ]);
    }

    public function test_show_returns_success(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($user)->get(route('tickets.show', $ticket));

        $response->assertOk();
    }

    public function test_edit_returns_success(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($user)->get(route('tickets.edit', $ticket));

        $response->assertOk();
    }

    public function test_update_updates_ticket(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();
        $updatedData = Ticket::factory()->make();

        $response = $this->actingAs($user)->put(route('tickets.update', $ticket), $updatedData->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tickets.index'));
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'description' => $updatedData->description,
        ]);
    }

    public function test_destroy_deletes_ticket(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($user)->delete(route('tickets.destroy', $ticket));

        $response->assertRedirect(route('tickets.index'));
        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id,
        ]);
    }
}
