<?php

namespace Database\Seeders;

use App\Models\ContractSituation;
use Illuminate\Database\Seeder;

class ContractSituationSeeder extends Seeder
{
    public function run(): void
    {
        $situations = [
            ['name' => 'Férias',                     'type' => 'F', 'is_active' => true],
            ['name' => 'Férias Prêmio',               'type' => 'F', 'is_active' => true],
            ['name' => 'Férias Individuais',          'type' => 'F', 'is_active' => true],
            ['name' => 'Férias Coletivas',            'type' => 'F', 'is_active' => true],

            ['name' => 'Licença Médica',              'type' => 'L', 'is_active' => true],
            ['name' => 'Licença Maternidade',         'type' => 'L', 'is_active' => true],
            ['name' => 'Licença Paternidade',         'type' => 'L', 'is_active' => true],
            ['name' => 'Licença Prêmio',              'type' => 'L', 'is_active' => true],
            ['name' => 'Licença por Interesse Particular', 'type' => 'L', 'is_active' => true],
            ['name' => 'Licença para Tratamento de Saúde', 'type' => 'L', 'is_active' => true],
            ['name' => 'Licença por Acidente em Serviço',  'type' => 'L', 'is_active' => true],
            ['name' => 'Licença para Atividade Política',  'type' => 'L', 'is_active' => true],
            ['name' => 'Licença para Capacitação',    'type' => 'L', 'is_active' => true],

            ['name' => 'Concessão de Diárias',        'type' => 'C', 'is_active' => true],
            ['name' => 'Concessão de Passagens',      'type' => 'C', 'is_active' => true],
            ['name' => 'Concessão de Transporte',     'type' => 'C', 'is_active' => true],
            ['name' => 'Concessão de Ajuda de Custo', 'type' => 'C', 'is_active' => true],

            ['name' => 'Afastamento para Cargo Comissionado', 'type' => 'A', 'is_active' => true],
            ['name' => 'Afastamento para Mandato Eletivo',    'type' => 'A', 'is_active' => true],
            ['name' => 'Afastamento para Estudo no Exterior', 'type' => 'A', 'is_active' => true],
            ['name' => 'Afastamento para Servir a Outro Órgão', 'type' => 'A', 'is_active' => true],
            ['name' => 'Afastamento para Exercício em outro Estado', 'type' => 'A', 'is_active' => true],

            ['name' => 'Aposentado',                  'type' => 'I', 'is_active' => false],
            ['name' => 'Exonerado',                   'type' => 'I', 'is_active' => false],
            ['name' => 'Demitido',                    'type' => 'I', 'is_active' => false],
            ['name' => 'Falecido',                    'type' => 'I', 'is_active' => false],
            ['name' => 'Cancelado',                   'type' => 'I', 'is_active' => false],
        ];

        foreach ($situations as $situation) {
            ContractSituation::firstOrCreate(
                ['name' => $situation['name']],
                $situation
            );
        }
    }
}
