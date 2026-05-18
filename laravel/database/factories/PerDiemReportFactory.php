<?php

namespace Database\Factories;

use App\Models\PerDiemReport;
use App\Models\PerDiemRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerDiemReportFactory extends Factory
{
    protected $model = PerDiemReport::class;

    public function definition(): array
    {
        return [
            'per_diem_request_id' => PerDiemRequest::factory(),
            'description' => fake()->paragraph(),
        ];
    }
}
