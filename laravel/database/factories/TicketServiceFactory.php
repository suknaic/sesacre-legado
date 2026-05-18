<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketCategoryType;
use App\Models\TicketPrimaryCategory;
use App\Models\TicketSecondaryCategory;
use App\Models\TicketService;
use App\Models\TicketStatus;
use App\Models\TicketPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketServiceFactory extends Factory
{
    protected $model = TicketService::class;

    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'ticket_secondary_category_id' => TicketSecondaryCategory::factory(),
            'hours_worked' => fake()->optional()->time(),
            'service_description' => fake()->sentence(),
            'service_value' => fake()->optional()->randomFloat(2, 50, 5000),
            'quantity' => fake()->optional()->numberBetween(1, 10),
            'total_value' => fake()->optional()->randomFloat(2, 50, 50000),
            'expense' => fake()->optional()->randomFloat(2, 10, 1000),
            'expense_description' => fake()->optional()->sentence(),
        ];
    }
}
