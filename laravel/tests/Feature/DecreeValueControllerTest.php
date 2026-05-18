<?php

namespace Tests\Feature;

use App\Models\DecreeValue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DecreeValueControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_model_can_be_created_via_factory(): void
    {
        $decreeValue = DecreeValue::factory()->create();

        $this->assertDatabaseHas('decree_values', [
            'id' => $decreeValue->id,
        ]);
    }

    public function test_index_returns_success(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('decree-values.index'));

        $response->assertOk();
    }

    public function test_create_returns_success(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('decree-values.create'));

        $response->assertOk();
    }

    public function test_store_creates_decree_value(): void
    {
        $user = User::factory()->create();
        $decreeValue = DecreeValue::factory()->make();

        $response = $this->actingAs($user)->post(route('decree-values.store'), $decreeValue->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('decree-values.index'));
        $this->assertDatabaseHas('decree_values', [
            'value' => $decreeValue->value,
        ]);
    }

    public function test_show_returns_success(): void
    {
        $user = User::factory()->create();
        $decreeValue = DecreeValue::factory()->create();

        $response = $this->actingAs($user)->get(route('decree-values.show', $decreeValue));

        $response->assertOk();
    }

    public function test_edit_returns_success(): void
    {
        $user = User::factory()->create();
        $decreeValue = DecreeValue::factory()->create();

        $response = $this->actingAs($user)->get(route('decree-values.edit', $decreeValue));

        $response->assertOk();
    }

    public function test_update_updates_decree_value(): void
    {
        $user = User::factory()->create();
        $decreeValue = DecreeValue::factory()->create();
        $updatedData = DecreeValue::factory()->make();

        $response = $this->actingAs($user)->put(route('decree-values.update', $decreeValue), $updatedData->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('decree-values.index'));
        $this->assertDatabaseHas('decree_values', [
            'id' => $decreeValue->id,
            'value' => $updatedData->value,
        ]);
    }

    public function test_destroy_deletes_decree_value(): void
    {
        $user = User::factory()->create();
        $decreeValue = DecreeValue::factory()->create();

        $response = $this->actingAs($user)->delete(route('decree-values.destroy', $decreeValue));

        $response->assertRedirect(route('decree-values.index'));
        $this->assertDatabaseMissing('decree_values', [
            'id' => $decreeValue->id,
        ]);
    }
}
