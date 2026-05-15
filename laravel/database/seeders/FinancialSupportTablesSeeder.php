<?php

namespace Database\Seeders;

use App\Models\CommitmentSituation;
use App\Models\CommitmentStatus;
use App\Models\CommitmentType;
use App\Models\ExpenseElementType;
use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class FinancialSupportTablesSeeder extends Seeder
{
    public function run(): void
    {
        ExpenseType::insert([
            ['code' => '1', 'name' => 'Despesas Correntes', 'is_active' => true],
            ['code' => '2', 'name' => 'Despesas de Capital', 'is_active' => true],
        ]);

        ExpenseElementType::insert([
            ['expense_type_id' => 1, 'code' => '11', 'name' => 'Pessoal e Encargos', 'is_active' => true],
            ['expense_type_id' => 1, 'code' => '12', 'name' => 'Juros e Encargos da Dívida', 'is_active' => true],
            ['expense_type_id' => 1, 'code' => '13', 'name' => 'Outras Despesas Correntes', 'is_active' => true],
            ['expense_type_id' => 2, 'code' => '21', 'name' => 'Investimentos', 'is_active' => true],
            ['expense_type_id' => 2, 'code' => '22', 'name' => 'Inversões Financeiras', 'is_active' => true],
            ['expense_type_id' => 2, 'code' => '23', 'name' => 'Amortização da Dívida', 'is_active' => true],
        ]);

        CommitmentType::insert([
            ['name' => 'Ordinário', 'is_active' => true],
            ['name' => 'Estimativo', 'is_active' => true],
            ['name' => 'Global', 'is_active' => true],
            ['name' => 'Suplementar', 'is_active' => true],
        ]);

        CommitmentSituation::insert([
            ['name' => 'Pendente', 'is_active' => true],
            ['name' => 'Em Andamento', 'is_active' => true],
            ['name' => 'Concluído', 'is_active' => true],
            ['name' => 'Cancelado', 'is_active' => true],
        ]);

        CommitmentStatus::insert([
            ['name' => 'Aguardando Liberação', 'is_active' => true],
            ['name' => 'Liberado', 'is_active' => true],
            ['name' => 'Bloqueado', 'is_active' => true],
            ['name' => 'Processado', 'is_active' => true],
        ]);
    }
}
