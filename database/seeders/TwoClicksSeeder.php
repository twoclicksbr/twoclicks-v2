<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TwoClicksSeeder extends Seeder
{
    public function run(): void
    {
        // Pessoa
        $personId = DB::table('people')->insertGetId([
            'first_name' => 'Alex',
            'surname'    => 'Alves de Almeida',
            'order'      => 1,
            'status'     => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usuário
        DB::table('users')->insert([
            'person_id'  => $personId,
            'email'      => 'alex@twoclicks.com',
            'password'   => Hash::make('Alex1985@'),
            'order'      => 1,
            'status'     => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === Módulo: Modules ===
        DB::table('modules')->insert([
            'name'                   => 'Módulos',
            'slug'                   => 'modules',
            'type'                   => 'module',
            'scope'                  => 'global',
            'icon'                   => null,
            'model'                  => 'Module',
            'service'                => 'ModuleService',
            'controller'             => 'ModuleController',
            'show_drag'              => true,
            'show_checkbox'          => true,
            'show_actions'           => true,
            'default_sort_field'     => 'id',
            'default_sort_direction' => 'asc',
            'per_page'               => 25,
            'view_index'             => null,
            'view_show'              => null,
            'view_modal'             => null,
            'after_store'            => 'index',
            'after_update'           => 'index',
            'after_restore'          => 'edit',
            'default_checked'        => false,
            'origin'                 => 'system',
            'order'                  => 1,
            'status'                 => true,
            'created_at'             => now(),
            'updated_at'             => now(),
        ]);
    }
}
