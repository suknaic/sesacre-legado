<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LegacyDataSeeder::class,
            FinancialSupportTablesSeeder::class,
            ProcurementSupportTablesSeeder::class,
            TicketSupportTablesSeeder::class,
            PlanningDiariasSupportTablesSeeder::class,
        ]);
    }
}
