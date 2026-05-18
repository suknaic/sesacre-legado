<?php

namespace Database\Factories;

use App\Models\DecreeType;
use App\Models\PerDiemRequest;
use App\Models\TransportType;
use App\Models\TravelClass;
use App\Models\TravelType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerDiemRequestFactory extends Factory
{
    protected $model = PerDiemRequest::class;

    public function definition(): array
    {
        return [
            'travel_type_id' => TravelType::factory(),
            'transport_type_id' => TransportType::factory(),
            'decree_type_id' => DecreeType::factory(),
            'travel_class_id' => TravelClass::factory(),
            'applicant_person_id' => null,
            'applicant_role_id' => null,
            'applicant_department_id' => null,
            'proposed_person_id' => null,
            'proposed_role_id' => null,
            'proposed_department_id' => null,
            'service_description' => fake()->sentence(),
            'locations' => fake()->city(),
            'notes' => fake()->optional()->text(),
            'creation_date' => fake()->date(),
            'requested_at' => fake()->dateTime(),
            'requester_person_id' => null,
            'requester_department_id' => null,
            'requester_center_id' => null,
            'has_return' => fake()->boolean(),
            'purchase_request_id' => null,
            'parent_per_diem_id' => null,
            'report_id' => null,
            'stage' => 1,
            'is_active' => true,
            'protocol_number' => null,
        ];
    }
}
