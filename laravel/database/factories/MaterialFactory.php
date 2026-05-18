<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'purchase_date' => fake()->optional()->date(),
            'brand' => fake()->optional()->company(),
            'model' => fake()->optional()->bothify('??-####'),
            'patrimony_number' => fake()->optional()->numerify('PAT####'),
            'price' => fake()->optional()->randomFloat(2, 100, 50000),
            'warranty_months' => fake()->optional()->numberBetween(1, 60),
            'serial_number' => fake()->optional()->bothify('SN####??'),
            'state' => fake()->optional()->randomElement(['Novo', 'Bom', 'Regular', 'Danificado', 'Inservível']),
            'ram_memory' => fake()->optional()->randomElement([4, 8, 16, 32, 64]),
            'processor' => fake()->optional()->word(),
            'hd_size' => fake()->optional()->randomElement([256, 512, 1024, 2048]),
            'has_wireless' => fake()->boolean(),
        ];
    }
}
