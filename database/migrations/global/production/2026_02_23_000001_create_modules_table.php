<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type', 20)->default('module');           // module, submodule, pivot
            $table->string('scope');                                  // global, platform, tenant (obrigatório, sem default)
            $table->string('icon')->nullable();                      // Classe do ícone (KTIcons)
            $table->string('model')->nullable();                     // Nome da classe Model (sem namespace)
            $table->string('service')->nullable();                   // Nome da classe Service (sem namespace)
            $table->string('controller')->nullable();                // Nome da classe Controller (sem namespace)
            $table->boolean('show_drag')->default(true);             // Handle de drag no grid
            $table->boolean('show_checkbox')->default(true);         // Checkbox de seleção no grid
            $table->boolean('show_actions')->default(true);          // Botões de ação no grid
            $table->string('default_sort_field')->default('id');     // Campo de ordenação padrão
            $table->string('default_sort_direction')->default('asc'); // asc / desc
            $table->integer('per_page')->default(25);                // 25, 50, 100
            $table->string('view_index')->nullable();                // null = dynamic/index
            $table->string('view_show')->nullable();                 // null = sem show (módulo simples)
            $table->string('view_modal')->nullable();                // null = dynamic/_modal
            $table->string('after_store')->default('index');         // Redirect após criar: index / show
            $table->string('after_update')->default('index');        // Redirect após atualizar: index / show
            $table->string('after_restore')->default('edit');        // Redirect após restaurar: index / edit
            $table->boolean('default_checked')->default(false);      // Pré-marca submódulo ao criar módulo
            $table->string('origin')->default('system');             // system / custom
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
