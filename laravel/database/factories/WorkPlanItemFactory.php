<?php

namespace Database\Factories;

use App\Models\WorkPlan;
use App\Models\WorkPlanItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkPlanItemFactory extends Factory
{
    protected $model = WorkPlanItem::class;

    public function definition(): array
    {
        $quantity = fake()->randomFloat(2, 1, 100);
        $unitValue = fake()->randomFloat(2, 10, 10000);

        return [
            'work_plan_id' => WorkPlan::factory(),
            'material_description' => fake()->sentence(3),
            'quantity' => $quantity,
            'unit_value' => $unitValue,
            'total_value' => $quantity * $unitValue,
            'status' => 'draft',
        ];
    }
}
