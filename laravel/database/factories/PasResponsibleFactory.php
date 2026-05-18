<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\PasResponsible;
use App\Models\PersonalInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasResponsibleFactory extends Factory
{
    protected $model = PasResponsible::class;

    public function definition(): array
    {
        return [
            'personal_info_id' => PersonalInfo::factory(),
            'organization_id' => Organization::factory(),
        ];
    }
}
