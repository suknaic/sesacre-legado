<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\State;
use App\Models\System;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegacyDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->importCountries();
            $this->importStates();
            $this->importCities();
            $this->importSystems();
            $this->importRoles();
            $this->importUsers();
            $this->importRoleUser();
            $this->syncSequences();
        });
    }

    protected function syncSequences(): void
    {
        $tables = [
            'countries', 'states', 'cities', 'systems', 'roles',
            'role_user', 'users',
        ];

        foreach ($tables as $table) {
            $seq = "{$table}_id_seq";
            DB::statement("SELECT setval('{$seq}', COALESCE((SELECT MAX(id) FROM {$table}), 1))");
        }
    }

    protected function importCountries(): void
    {
        DB::table('ses_pais')->orderBy('id_pais')->each(function ($legacy) {
            Country::withoutEvents(fn () => Country::create([
                'id' => $legacy->id_pais,
                'code' => $legacy->nm_sigla ?? '',
                'name' => $legacy->nm_pais,
                'is_active' => (bool) $legacy->st_ativo,
            ]));
        });
    }

    protected function importStates(): void
    {
        DB::table('ses_estado')->orderBy('id_estado')->each(function ($legacy) {
            State::withoutEvents(fn () => State::create([
                'id' => $legacy->id_estado,
                'country_id' => $legacy->id_pais,
                'code' => $legacy->nm_sigla ?? '',
                'name' => $legacy->nm_estado,
                'is_active' => (bool) $legacy->st_ativo,
            ]));
        });
    }

    protected function importCities(): void
    {
        DB::table('ses_cidade')->orderBy('id_cidade')->each(function ($legacy) {
            City::withoutEvents(fn () => City::create([
                'id' => $legacy->id_cidade,
                'state_id' => $legacy->id_estado,
                'name' => $legacy->nm_cidade,
                'health_region_id' => $legacy->id_regional_saude ?: null,
                'geo_region_id' => $legacy->id_regional_geo ?: null,
                'is_active' => (bool) $legacy->st_ativo,
            ]));
        });
    }

    protected function importSystems(): void
    {
        DB::table('ses_sistema')->orderBy('id_sistema')->each(function ($legacy) {
            System::withoutEvents(fn () => System::create([
                'id' => $legacy->id_sistema,
                'name' => $legacy->nm_sistema,
                'is_active' => (bool) $legacy->st_ativo,
            ]));
        });
    }

    protected function importRoles(): void
    {
        DB::table('ses_perfil')->orderBy('id_perfil')->each(function ($legacy) {
            Role::withoutEvents(fn () => Role::create([
                'id' => $legacy->id_perfil,
                'system_id' => $legacy->id_sistema ?: null,
                'name' => $legacy->nm_perfil,
                'is_active' => (bool) $legacy->st_ativo,
            ]));
        });
    }

    protected function importUsers(): void
    {
        DB::table('ses_pessoa')->orderBy('id_pessoa')->each(function ($legacy) {
            DB::table('users')->insert([
                'id' => $legacy->id_pessoa,
                'name' => $legacy->nm_pessoa,
                'email' => $legacy->nm_email,
                'password' => $legacy->nm_senha,
                'phone' => $legacy->nr_telefone_residencial ?: null,
                'mobile' => $legacy->nr_telefone_celular ?: null,
                'address' => $legacy->ds_logradouro ?: null,
                'neighborhood' => $legacy->ds_bairro ?: null,
                'complement' => $legacy->ds_complemento ?: null,
                'zip_code' => $legacy->nr_cep ?: null,
                'street_number' => $legacy->nr_numero ?: null,
                'city_id' => $legacy->id_cidade ?: null,
                'notes' => $legacy->ds_observacao ?: null,
                'last_login_at' => $legacy->dh_login ?: null,
                'is_active' => (bool) $legacy->st_ativo,
                'birth_city_id' => $legacy->id_naturalidade ?: null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    protected function importRoleUser(): void
    {
        DB::table('ses_perfil_pessoa')->orderBy('id_perfil_pessoa')->each(function ($legacy) {
            DB::table('role_user')->insert([
                'role_id' => $legacy->id_perfil,
                'user_id' => $legacy->id_pessoa,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
