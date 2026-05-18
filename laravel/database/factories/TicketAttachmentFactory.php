<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketCategory;
use App\Models\TicketCategoryType;
use App\Models\TicketPrimaryCategory;
use App\Models\TicketSecondaryCategory;
use App\Models\TicketStatus;
use App\Models\TicketPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketAttachmentFactory extends Factory
{
    protected $model = TicketAttachment::class;

    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'link' => fake()->url(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
