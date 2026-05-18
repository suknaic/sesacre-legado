<?php

namespace Database\Factories;

use App\Models\ContractSituation;
use App\Models\EmploymentContract;
use App\Models\JobFunction;
use App\Models\Organization;
use App\Models\RecruitmentHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecruitmentHistoryFactory extends Factory
{
    protected $model = RecruitmentHistory::class;

    public function definition(): array
    {
        return [
            'employment_contract_id' => EmploymentContract::factory(),
            'organization_id' => Organization::factory(),
            'job_function_id' => JobFunction::factory(),
            'contract_situation_id' => ContractSituation::factory(),
            'history_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'observation' => fake()->sentence(),
        ];
    }
}
