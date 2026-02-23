<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TwoClicksReset extends Command
{
    protected $signature = 'twoclicks:reset {--force : Executar sem confirmação}';

    protected $description = 'Reset completo do banco tc_main (migrate:fresh + seed)';

    public function handle(): int
    {
        if (!$this->option('force') && !$this->confirm('⚠️  ATENÇÃO: Isso vai APAGAR TODOS os dados do banco tc_main. Deseja continuar?')) {
            $this->info('Operação cancelada.');
            return 0;
        }

        $this->newLine();
        $this->info('🔄 Iniciando reset do TwoClicks...');
        $this->newLine();

        // migrate:fresh
        $this->warn('1/2 — Rodando migrate:fresh...');
        $this->call('migrate:fresh', ['--force' => true]);
        $this->info('✅ Migrations executadas.');
        $this->newLine();

        // seed
        $this->warn('2/2 — Rodando TwoClicksSeeder...');
        $this->call('db:seed', [
            '--class' => 'Database\\Seeders\\TwoClicksSeeder',
            '--force' => true,
        ]);
        $this->info('✅ Seeder executado.');
        $this->newLine();

        // Resumo
        $this->info('🎉 Reset concluído com sucesso!');
        $this->table(
            ['Etapa', 'Status'],
            [
                ['migrate:fresh', '✅ OK'],
                ['TwoClicksSeeder', '✅ OK'],
            ]
        );

        return 0;
    }
}
