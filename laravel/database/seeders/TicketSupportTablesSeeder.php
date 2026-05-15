<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use App\Models\TicketCategoryType;
use App\Models\TicketCondition;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use Illuminate\Database\Seeder;

class TicketSupportTablesSeeder extends Seeder
{
    public function run(): void
    {
        TicketStatus::insert([
            ['name' => 'Aberto', 'is_active' => true],
            ['name' => 'Em Atendimento', 'is_active' => true],
            ['name' => 'Aguardando Peça', 'is_active' => true],
            ['name' => 'Resolvido', 'is_active' => true],
            ['name' => 'Cancelado', 'is_active' => true],
        ]);

        TicketPriority::insert([
            ['name' => 'Baixa', 'code' => 'low', 'is_active' => true],
            ['name' => 'Média', 'code' => 'medium', 'is_active' => true],
            ['name' => 'Alta', 'code' => 'high', 'is_active' => true],
            ['name' => 'Urgente', 'code' => 'urgent', 'is_active' => true],
        ]);

        TicketCondition::insert([
            ['name' => 'Novo', 'is_active' => true],
            ['name' => 'Bom', 'is_active' => true],
            ['name' => 'Regular', 'is_active' => true],
            ['name' => 'Danificado', 'is_active' => true],
            ['name' => 'Inservível', 'is_active' => true],
        ]);

        $cat = TicketCategory::create(['name' => 'Informática', 'is_active' => true]);
        $tipo = TicketCategoryType::create(['ticket_category_id' => $cat->id, 'name' => 'Suporte Técnico', 'is_active' => true]);
        $tipo->primaryCategories()->createMany([
            ['name' => 'Hardware', 'is_active' => true],
            ['name' => 'Software', 'is_active' => true],
            ['name' => 'Rede', 'is_active' => true],
        ]);
    }
}
