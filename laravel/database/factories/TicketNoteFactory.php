<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketCategoryType;
use App\Models\TicketPrimaryCategory;
use App\Models\TicketNote;
use App\Models\TicketSecondaryCategory;
use App\Models\TicketStatus;
use App\Models\TicketPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketNoteFactory extends Factory
{
    protected $model = TicketNote::class;

    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'person_id' => null,
            'note' => fake()->paragraph(),
            'note_date' => fake()->dateTimeThisYear(),
        ];
    }
}
