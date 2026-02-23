<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TwoClicksResetLog extends Command
{
    protected $signature = 'twoclicks:reset-log {--force : Executar sem confirmação}';

    protected $description = 'Reset do schema log (drop + migrate)';

    public function handle(): int
    {
        if (!$this->option('force') && !$this->confirm('⚠️  ATENÇÃO: Isso vai APAGAR o schema log. Deseja continuar?')) {
            $this->info('Operação cancelada.');
            return 0;
        }

        $this->newLine();
        $this->info('🔄 Iniciando reset do schema log...');
        $this->newLine();

        // 1. Drop schema log
        $this->warn('1/3 — Dropando schema log...');
        DB::statement('DROP SCHEMA IF EXISTS log CASCADE');
        $this->info('✅ Schema log removido.');
        $this->newLine();

        // 2. Criar + migrate
        $this->warn('2/3 — Criando schema log + migrate...');
        DB::statement('CREATE SCHEMA log');
        DB::statement('SET search_path TO log');
        $this->call('migrate', [
            '--path'  => 'database/migrations/global/log',
            '--force' => true,
        ]);
        $this->info('✅ Schema log migrado.');
        $this->newLine();

        // 3. Restaurar search_path
        $this->warn('3/3 — Restaurando search_path para production...');
        DB::statement('SET search_path TO production');
        $this->info('✅ search_path restaurado.');
        $this->newLine();

        // Resumo
        $this->info('🎉 Reset de log concluído!');
        $this->table(
            ['Etapa', 'Status'],
            [
                ['Schema log dropado',                  '✅ OK'],
                ['Schema log criado + migrado',         '✅ OK'],
                ['search_path restaurado para production', '✅ OK'],
            ]
        );

        return 0;
    }
}
