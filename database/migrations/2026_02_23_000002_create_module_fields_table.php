<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->boolean('main')->default(false);                  // Campo padrão do sistema (não editável)
            $table->boolean('is_custom')->default(false);             // Criado pelo tenant
            $table->string('icon', 100)->nullable();                  // Ícone do campo
            $table->string('name');                                   // Nome da coluna (first_name, surname)
            $table->string('label');                                  // Rótulo exibido (Nome, Sobrenome)
            $table->string('type', 50);                               // string, integer, boolean, decimal, text, date, datetime, json, bigint, timestamp
            $table->integer('length')->nullable();                    // Tamanho do campo (255, 14)
            $table->integer('precision')->nullable();                 // Casas decimais
            $table->string('default')->nullable();                    // Valor padrão
            $table->boolean('nullable')->default(false);              // Aceita NULL
            $table->boolean('required')->default(false);              // Obrigatório na validação
            $table->boolean('unique')->default(false);                // Unicidade (validação aplicacional, NÃO constraint)
            $table->boolean('index')->default(false);                 // Criar índice no banco
            $table->string('unique_table')->nullable();               // Módulo para validar unicidade remota
            $table->string('unique_column')->nullable();              // Campo para comparar unicidade remota
            $table->string('fk_table')->nullable();                   // Tabela referenciada (brands)
            $table->string('fk_column')->nullable();                  // Coluna do vínculo (id)
            $table->string('fk_label')->nullable();                   // Coluna exibida no select/grid (name)
            $table->string('auto_from')->nullable();                  // Campo que gera valor automaticamente
            $table->string('auto_type', 50)->nullable();              // Tipo: slug, uppercase, lowercase
            $table->string('min', 50)->nullable();                    // Validação mínima
            $table->string('max', 50)->nullable();                    // Validação máxima
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->string('origin')->default('system');              // system / custom
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_fields');
    }
};
