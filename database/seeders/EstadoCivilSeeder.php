<?php

use Illuminate\Database\Seeder;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estadosCivis = [
            ['nome' => 'Solteiro(a)'],
            ['nome' => 'Casado(a)'],
            ['nome' => 'Divorciado(a)'],
            ['nome' => 'Viúvo(a)']
        ];

        foreach ($estadosCivis as $estadoCivil) {
            DB::table('estado_civils')->insert([
                'nome' => $estadoCivil['nome'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}