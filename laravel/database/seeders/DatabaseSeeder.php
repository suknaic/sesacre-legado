<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BrazilianDataSeeder::class,
            MaritalStatusSeeder::class,
            SystemSeeder::class,
            RoleSeeder::class,
            ContractSituationSeeder::class,
            LegacyDataSeeder::class,
            FinancialSupportTablesSeeder::class,
            ProcurementSupportTablesSeeder::class,
            TicketSupportTablesSeeder::class,
            PlanningDiariasSupportTablesSeeder::class,
        ]);
    }
}
