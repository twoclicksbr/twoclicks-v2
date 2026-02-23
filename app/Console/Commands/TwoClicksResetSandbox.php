<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TwoClicksResetSandbox extends Command
{
    protected $signature = 'twoclicks:reset-sandbox {--force : Executar sem confirmação}';

    protected $description = 'Reset do schema sandbox (drop + migrate + seed)';

    public function handle(): int
    {
        if (!$this->option('force') && !$this->confirm('⚠️  ATENÇÃO: Isso vai APAGAR o schema sandbox. Deseja continuar?')) {
            $this->info('Operação cancelada.');
            return 0;
        }

        $this->newLine();
        $this->info('🔄 Iniciando reset do schema sandbox...');
        $this->newLine();

        // 1. Drop schema sandbox
        $this->warn('1/3 — Dropando schema sandbox...');
        DB::statement('DROP SCHEMA IF EXISTS sandbox CASCADE');
        $this->info('✅ Schema sandbox removido.');
        $this->newLine();

        // 2. Criar + migrate + seed
        $this->warn('2/3 — Criando schema sandbox + migrate + seed...');
        DB::statement('CREATE SCHEMA sandbox');
        DB::statement('SET search_path TO sandbox');
        $this->call('migrate', [
            '--path'  => 'database/migrations/global/sandbox',
            '--force' => true,
        ]);
        $this->call('db:seed', [
            '--class' => 'Database\\Seeders\\TwoClicksSeeder',
            '--force' => true,
        ]);
        $this->info('✅ Schema sandbox migrado e seedado.');
        $this->newLine();

        // 3. Restaurar search_path
        $this->warn('3/3 — Restaurando search_path para production...');
        DB::statement('SET search_path TO production');
        $this->info('✅ search_path restaurado.');
        $this->newLine();

        // Resumo
        $this->info('🎉 Reset de sandbox concluído!');
        $this->table(
            ['Etapa', 'Status'],
            [
                ['Schema sandbox dropado',                    '✅ OK'],
                ['Schema sandbox criado + migrado + seedado', '✅ OK'],
                ['search_path restaurado para production',    '✅ OK'],
            ]
        );

        return 0;
    }
}
