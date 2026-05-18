<?php

namespace Database\Factories;

use App\Models\OrganizationDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationDetailFactory extends Factory
{
    protected $model = OrganizationDetail::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company().' - '.fake()->word(),
            'is_active' => true,
        ];
    }
}
