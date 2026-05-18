<?php

namespace Database\Factories;

use App\Models\TicketCategory;
use App\Models\TicketCategoryType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketCategoryTypeFactory extends Factory
{
    protected $model = TicketCategoryType::class;

    public function definition(): array
    {
        return [
            'ticket_category_id' => TicketCategory::factory(),
            'name' => fake()->word(),
            'is_active' => true,
        ];
    }
}
