<?php

namespace Database\Factories;

use App\Models\AnnualPlan;
use App\Models\PasAction;
use App\Models\PlanAction;
use App\Models\PpaProjectActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasActionFactory extends Factory
{
    protected $model = PasAction::class;

    public function definition(): array
    {
        return [
            'annual_plan_id' => AnnualPlan::factory(),
            'plan_action_id' => PlanAction::factory(),
            'ppa_project_activity_id' => PpaProjectActivity::factory(),
            'partnership_desc' => fake()->optional()->sentence(),
            'programming_goal' => fake()->optional()->sentence(),
            'programming_indicator' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }
}
