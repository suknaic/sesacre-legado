<?php

namespace Database\Seeders;

use App\Models\MaritalStatus;
use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'Solteiro(a)',
            'Casado(a)',
            'Divorciado(a)',
            'Separado(a) Judicialmente',
            'Viúvo(a)',
            'União Estável',
        ];

        foreach ($statuses as $name) {
            MaritalStatus::firstOrCreate(['name' => $name]);
        }
    }
}
