<?php

namespace Database\Factories;

use App\Models\AnnualPlan;
use App\Models\HealthIndicator;
use App\Models\PasActionIndicator;
use App\Models\PlanAction;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasActionIndicatorFactory extends Factory
{
    protected $model = PasActionIndicator::class;

    public function definition(): array
    {
        return [
            'annual_plan_id' => AnnualPlan::factory(),
            'plan_action_id' => PlanAction::factory(),
            'health_indicator_id' => HealthIndicator::factory(),
        ];
    }
}
