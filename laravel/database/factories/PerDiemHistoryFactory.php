<?php

namespace Database\Factories;

use App\Models\PerDiemHistory;
use App\Models\PerDiemRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerDiemHistoryFactory extends Factory
{
    protected $model = PerDiemHistory::class;

    public function definition(): array
    {
        return [
            'per_diem_request_id' => PerDiemRequest::factory(),
            'person_id' => null,
            'history_date' => fake()->dateTime(),
            'description' => fake()->sentence(),
        ];
    }
}
