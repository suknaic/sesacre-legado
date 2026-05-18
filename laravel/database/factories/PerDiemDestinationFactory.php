<?php

namespace Database\Factories;

use App\Models\PerDiemDestination;
use App\Models\PerDiemRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerDiemDestinationFactory extends Factory
{
    protected $model = PerDiemDestination::class;

    public function definition(): array
    {
        return [
            'per_diem_request_id' => PerDiemRequest::factory(),
            'origin_city_id' => null,
            'destination_city_id' => null,
            'start_at' => fake()->dateTime(),
            'end_at' => fake()->dateTime(),
            'transport_id' => null,
            'decree_id' => null,
            'travel_class_id' => null,
            'has_overnight_stay' => fake()->boolean(),
            'quantity' => fake()->randomDigitNotNull(),
            'value' => fake()->randomFloat(2, 50, 5000),
        ];
    }
}
