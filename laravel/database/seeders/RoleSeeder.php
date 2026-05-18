<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\System;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $rh = System::where('name', 'RH')->first();

        if ($rh) {
            Role::firstOrCreate(['system_id' => $rh->id, 'name' => 'Administrador RH'], ['is_active' => true]);
            Role::firstOrCreate(['system_id' => $rh->id, 'name' => 'Usuário RH'], ['is_active' => true]);
        }
    }
}
