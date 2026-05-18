<?php

namespace Database\Factories;

use App\Models\Resource;
use App\Models\System;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition(): array
    {
        return [
            'system_id' => System::factory(),
            'name' => fake()->unique()->word(),
            'route' => fake()->optional()->url(),
            'description' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }
}
