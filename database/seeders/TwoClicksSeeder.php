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
            'email'      => 'alex@twoclicks.com.br',
            'password'   => Hash::make('Alex1985@'),
            'order'      => 1,
            'status'     => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
