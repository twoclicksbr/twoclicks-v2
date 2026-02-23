<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TwoClicksReset extends Command
{
    protected $signature = 'twoclicks:reset {--force : Executar sem confirmação}';

    protected $description = 'Reset completo do banco tc_main (production + sandbox + log)';

    public function handle(): int
    {
        if (!$this->option('force') && !$this->confirm('⚠️  ATENÇÃO: Isso vai APAGAR TODOS os dados do banco tc_main. Deseja continuar?')) {
            $this->info('Operação cancelada.');
            return 0;
        }

        $this->newLine();
        $this->info('🔄 Iniciando reset completo do TwoClicks...');
        $this->newLine();

        // 1. Drop dos 3 schemas
        $this->warn('1/5 — Dropando schemas (production, sandbox, log)...');
        DB::statement('DROP SCHEMA IF EXISTS production CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS sandbox CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS log CASCADE');
        $this->info('✅ Schemas removidos.');
        $this->newLine();

        // 2. Schema sandbox
        $this->warn('2/5 — Criando schema sandbox + migrate + seed...');
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
        $this->info('✅ Schema sandbox pronto.');
        $this->newLine();

        // 3. Schema production
        $this->warn('3/5 — Criando schema production + migrate + seed...');
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
        $this->info('✅ Schema production pronto.');
        $this->newLine();

        // 4. Schema log
        $this->warn('4/5 — Criando schema log + migrate...');
        DB::statement('CREATE SCHEMA log');
        DB::statement('SET search_path TO log');
        $this->call('migrate', [
            '--path'  => 'database/migrations/global/log',
            '--force' => true,
        ]);
        $this->info('✅ Schema log pronto.');
        $this->newLine();

        // 5. Restaurar search_path para production
        $this->warn('5/5 — Restaurando search_path para production...');
        DB::statement('SET search_path TO production');
        $this->info('✅ search_path restaurado.');
        $this->newLine();

        // Resumo
        $this->info('🎉 Reset completo concluído com sucesso!');
        $this->table(
            ['Etapa', 'Status'],
            [
                ['Schemas dropados (production, sandbox, log)',         '✅ OK'],
                ['Schema sandbox criado + migrado + seedado',          '✅ OK'],
                ['Schema production criado + migrado + seedado',       '✅ OK'],
                ['Schema log criado + migrado',                        '✅ OK'],
                ['search_path restaurado para production',             '✅ OK'],
            ]
        );

        return 0;
    }
}
