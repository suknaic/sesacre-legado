<?php

namespace Database\Factories;

use App\Models\TicketPrimaryCategory;
use App\Models\TicketSecondaryCategory;
use App\Models\TicketStatus;
use App\Models\TicketPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketSecondaryCategoryFactory extends Factory
{
    protected $model = TicketSecondaryCategory::class;

    public function definition(): array
    {
        return [
            'ticket_primary_category_id' => TicketPrimaryCategory::factory(),
            'name' => fake()->word(),
            'value' => fake()->optional()->randomFloat(2, 10, 1000),
            'is_active' => true,
        ];
    }
}
