<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    public function run(): void
    {
        $systems = ['RH', 'Planejamento', 'Orçamento', 'Financeiro', 'Contábil', 'Compras', 'Diárias', 'Chamados'];

        foreach ($systems as $name) {
            System::firstOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
