<?php

namespace Database\Seeders;

use App\Models\ProcurementModality;
use App\Models\ProcurementObject;
use App\Models\ProcurementSituation;
use App\Models\PurchaseRequestSituation;
use Illuminate\Database\Seeder;

class ProcurementSupportTablesSeeder extends Seeder
{
    public function run(): void
    {
        ProcurementModality::insert([
            ['name' => 'Dispensa de Licitação'],
            ['name' => 'Inexigibilidade'],
            ['name' => 'Pregão Presencial'],
            ['name' => 'Pregão Eletrônico'],
            ['name' => 'Concorrência'],
            ['name' => 'Tomada de Preços'],
            ['name' => 'Concurso'],
            ['name' => 'Leilão'],
        ]);

        ProcurementObject::insert([
            ['name' => 'Contratação de Serviços'],
            ['name' => 'Aquisição de Materiais'],
            ['name' => 'Obras e Instalações'],
            ['name' => 'Locação de Imóveis'],
            ['name' => 'Serviços de Engenharia'],
            ['name' => 'Equipamentos de Informática'],
            ['name' => 'Material de Consumo'],
            ['name' => 'Medicamentos'],
        ]);

        ProcurementSituation::insert([
            ['name' => 'Planejamento'],
            ['name' => 'Em Andamento'],
            ['name' => 'Adjudicado'],
            ['name' => 'Homologado'],
            ['name' => 'Cancelado'],
            ['name' => 'Suspenso'],
        ]);

        PurchaseRequestSituation::insert([
            ['name' => 'Rascunho', 'is_active' => true],
            ['name' => 'Aguardando Aprovação', 'is_active' => true],
            ['name' => 'Aprovado', 'is_active' => true],
            ['name' => 'Empenhado', 'is_active' => true],
            ['name' => 'Cancelado', 'is_active' => true],
        ]);
    }
}
