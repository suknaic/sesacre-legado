<?php

namespace Tests\Feature;

use App\Models\PerDiemRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerDiemRequestControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_model_can_be_created_via_factory(): void
    {
        $perDiemRequest = PerDiemRequest::factory()->create();

        $this->assertDatabaseHas('per_diem_requests', [
            'id' => $perDiemRequest->id,
        ]);
    }

    public function test_index_returns_success(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('per-diem-requests.index'));

        $response->assertOk();
    }

    public function test_create_returns_success(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('per-diem-requests.create'));

        $response->assertOk();
    }

    public function test_store_creates_per_diem_request(): void
    {
        $user = User::factory()->create();
        $perDiemRequest = PerDiemRequest::factory()->make();

        $response = $this->actingAs($user)->post(route('per-diem-requests.store'), $perDiemRequest->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('per-diem-requests.index'));
        $this->assertDatabaseHas('per_diem_requests', [
            'service_description' => $perDiemRequest->service_description,
        ]);
    }

    public function test_show_returns_success(): void
    {
        $user = User::factory()->create();
        $perDiemRequest = PerDiemRequest::factory()->create();

        $response = $this->actingAs($user)->get(route('per-diem-requests.show', $perDiemRequest));

        $response->assertOk();
    }

    public function test_edit_returns_success(): void
    {
        $user = User::factory()->create();
        $perDiemRequest = PerDiemRequest::factory()->create();

        $response = $this->actingAs($user)->get(route('per-diem-requests.edit', $perDiemRequest));

        $response->assertOk();
    }

    public function test_update_updates_per_diem_request(): void
    {
        $user = User::factory()->create();
        $perDiemRequest = PerDiemRequest::factory()->create();
        $updatedData = PerDiemRequest::factory()->make();

        $response = $this->actingAs($user)->put(route('per-diem-requests.update', $perDiemRequest), $updatedData->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('per-diem-requests.index'));
        $this->assertDatabaseHas('per_diem_requests', [
            'id' => $perDiemRequest->id,
            'service_description' => $updatedData->service_description,
        ]);
    }

    public function test_destroy_deletes_per_diem_request(): void
    {
        $user = User::factory()->create();
        $perDiemRequest = PerDiemRequest::factory()->create();

        $response = $this->actingAs($user)->delete(route('per-diem-requests.destroy', $perDiemRequest));

        $response->assertRedirect(route('per-diem-requests.index'));
        $this->assertDatabaseMissing('per_diem_requests', [
            'id' => $perDiemRequest->id,
        ]);
    }
}
