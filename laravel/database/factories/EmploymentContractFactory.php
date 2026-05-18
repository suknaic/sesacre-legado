<?php

namespace Database\Factories;

use App\Models\EmploymentBond;
use App\Models\EmploymentContract;
use App\Models\JobPosition;
use App\Models\LegalEntity;
use App\Models\PersonalInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmploymentContractFactory extends Factory
{
    protected $model = EmploymentContract::class;

    public function definition(): array
    {
        return [
            'personal_info_id' => PersonalInfo::factory(),
            'employment_bond_id' => EmploymentBond::factory(),
            'job_position_id' => JobPosition::factory(),
            'legal_entity_id' => LegalEntity::factory(),
            'admission_date' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'workload' => fake()->numberBetween(20, 40),
            'is_active' => true,
        ];
    }
}
