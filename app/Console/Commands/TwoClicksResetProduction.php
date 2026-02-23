<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TwoClicksResetProduction extends Command
{
    protected $signature = 'twoclicks:reset-production {--force : Executar sem confirmação}';

    protected $description = 'Reset do schema production (drop + migrate + seed)';

    public function handle(): int
    {
        if (!$this->option('force') && !$this->confirm('⚠️  ATENÇÃO: Isso vai APAGAR o schema production. Deseja continuar?')) {
            $this->info('Operação cancelada.');
            return 0;
        }

        $this->newLine();
        $this->info('🔄 Iniciando reset do schema production...');
        $this->newLine();

        // 1. Drop schema production
        $this->warn('1/3 — Dropando schema production...');
        DB::statement('DROP SCHEMA IF EXISTS production CASCADE');
        $this->info('✅ Schema production removido.');
        $this->newLine();

        // 2. Criar + migrate + seed
        $this->warn('2/3 — Criando schema production + migrate + seed...');
        DB::statement('CREATE SCHEMA production');
        DB::statement('SET search_path TO production');
        $this->call('migrate', [
            '--path'  => 'database/migrations/global/production',
            '--force' => true,
        ]);
        $this->call('db:seed', [
            '--class' => 'Database\\Seeders\\TwoClicksSeeder',
            '--force' => true,
        ]);
        $this->info('✅ Schema production migrado e seedado.');
        $this->newLine();

        // 3. Restaurar search_path
        $this->warn('3/3 — Restaurando search_path para production...');
        DB::statement('SET search_path TO production');
        $this->info('✅ search_path restaurado.');
        $this->newLine();

        // Resumo
        $this->info('🎉 Reset de production concluído!');
        $this->table(
            ['Etapa', 'Status'],
            [
                ['Schema production dropado',                    '✅ OK'],
                ['Schema production criado + migrado + seedado', '✅ OK'],
                ['search_path restaurado para production',       '✅ OK'],
            ]
        );

        return 0;
    }
}
