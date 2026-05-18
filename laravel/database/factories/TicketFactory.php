<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketCategoryType;
use App\Models\TicketPrimaryCategory;
use App\Models\TicketPriority;
use App\Models\TicketSecondaryCategory;
use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'description' => fake()->sentence(),
            'requester_phone' => fake()->optional()->phoneNumber(),
            'ticket_status_id' => TicketStatus::factory(),
            'ticket_priority_id' => TicketPriority::factory(),
            'ticket_secondary_category_id' => TicketSecondaryCategory::factory(),
            'deadline' => fake()->optional()->date(),
            'opened_at' => fake()->dateTimeThisYear(),
        ];
    }

    public function withCategory(): static
    {
        return $this->state(fn (array $attributes) => [
            'ticket_secondary_category_id' => TicketSecondaryCategory::factory(),
        ]);
    }

    public function resolved(): static
    {
        return $this->state(fn (array $attributes) => [
            'resolution' => fake()->sentence(),
            'resolved_at' => fake()->dateTimeThisYear(),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'cancel_reason' => fake()->sentence(),
            'cancelled_at' => fake()->dateTimeThisYear(),
        ]);
    }
}
