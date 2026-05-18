<?php

namespace Database\Factories;

use App\Models\TicketCategoryType;
use App\Models\TicketPrimaryCategory;
use App\Models\TicketSecondaryCategory;
use App\Models\TicketStatus;
use App\Models\TicketPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketPrimaryCategoryFactory extends Factory
{
    protected $model = TicketPrimaryCategory::class;

    public function definition(): array
    {
        return [
            'ticket_category_type_id' => TicketCategoryType::factory(),
            'name' => fake()->word(),
            'is_active' => true,
        ];
    }
}
