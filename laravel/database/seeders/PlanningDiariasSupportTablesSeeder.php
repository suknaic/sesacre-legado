<?php

namespace Database\Seeders;

use App\Models\DecreeType;
use App\Models\MeasurementUnit;
use App\Models\TransportType;
use App\Models\TravelClass;
use App\Models\TravelType;
use Illuminate\Database\Seeder;

class PlanningDiariasSupportTablesSeeder extends Seeder
{
    public function run(): void
    {
        MeasurementUnit::insert([
            ['name' => 'Unidade'],
            ['name' => 'Kg'],
            ['name' => 'Litro'],
            ['name' => 'Metro'],
            ['name' => 'Caixa'],
            ['name' => 'Hora'],
            ['name' => 'Dia'],
        ]);

        TravelClass::insert([
            ['name' => 'Secretário', 'code' => 'SEC', 'is_active' => true],
            ['name' => 'Chefe de Departamento', 'code' => 'CHEFE', 'is_active' => true],
            ['name' => 'Servidor Efetivo', 'code' => 'EFETIVO', 'is_active' => true],
            ['name' => 'Servidor Comissionado', 'code' => 'COMISS', 'is_active' => true],
        ]);

        TransportType::insert([
            ['name' => 'Aéreo', 'is_active' => true],
            ['name' => 'Terrestre', 'is_active' => true],
            ['name' => 'Fluvial', 'is_active' => true],
            ['name' => 'Próprio', 'is_active' => true],
        ]);

        DecreeType::insert([
            ['name' => 'Decreto Estadual', 'is_active' => true],
            ['name' => 'Portaria', 'is_active' => true],
            ['name' => 'Resolução', 'is_active' => true],
        ]);

        TravelType::insert([
            ['name' => 'Nacional'],
            ['name' => 'Internacional'],
            ['name' => 'Estadual'],
            ['name' => 'Municipal'],
        ]);
    }
}
