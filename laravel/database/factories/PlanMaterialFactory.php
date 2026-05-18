<?php

namespace Database\Factories;

use App\Models\PlanMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanMaterialFactory extends Factory
{
    protected $model = PlanMaterial::class;

    public function definition(): array
    {
        return [
            'code' => fake()->unique()->bothify('MAT###'),
            'name' => fake()->word(),
            'description_code' => fake()->bothify('DESC##'),
            'description_name' => fake()->sentence(2),
            'group_code' => fake()->bothify('GRP##'),
            'group_name' => fake()->word(),
            'subgroup_code' => fake()->bothify('SUB##'),
            'subgroup_name' => fake()->word(),
            'material_type' => fake()->randomElement(['Consumo', 'Permanente', 'Serviço']),
            'expense_element_code' => fake()->bothify('ELE##'),
            'expense_type_id' => fake()->optional()->numberBetween(1, 10),
        ];
    }
}
