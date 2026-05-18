<?php

namespace Database\Factories;

use App\Models\CentralDemand;
use App\Models\Organization;
use App\Models\PersonalInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CentralDemandFactory extends Factory
{
    protected $model = CentralDemand::class;

    public function definition(): array
    {
        return [
            'personal_info_id' => PersonalInfo::factory(),
            'organization_id' => Organization::factory(),
        ];
    }
}
