<?php

namespace Database\Factories;

use App\Models\DeliveryOrder;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryOrderFactory extends Factory
{
    protected $model = DeliveryOrder::class;

    public function definition(): array
    {
        return [
            'order_date' => fake()->date(),
            'material_description' => fake()->sentence(3),
            'quantity_ordered' => fake()->randomNumber(3),
            'quantity_received' => 0,
            'organization_id' => Organization::factory(),
            'status' => 'ordered',
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
