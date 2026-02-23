<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_fields_ui', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_field_id')->constrained('module_fields')->cascadeOnDelete();

            // === Componente e configuração base ===
            $table->string('component', 50);                          // input, select, select_module, date, datetime, textarea, switch, upload, checkbox, radio, password, date_range, datetime_range
            $table->json('options')->nullable();                       // JSON para badges, selects, checkboxes, radios
            $table->string('placeholder')->nullable();                // Texto de dica
            $table->string('mask', 100)->nullable();                  // Máscara de input (Inputmask.js)
            $table->string('icon', 100)->nullable();                  // Ícone do campo no form
            $table->text('tooltip')->nullable();                      // Texto do tooltip
            $table->string('tooltip_direction', 20)->default('top');  // top, bottom, left, right

            // === Layout do formulário ===
            $table->string('grid_col', 20)->default('col-md-12');     // Largura no formulário (Bootstrap grid)
            $table->integer('form_order')->default(0);                // Ordem do campo no formulário

            // === Visibilidade ===
            $table->boolean('visible_index')->default(false);         // Aparece no grid (listagem)
            $table->boolean('visible_show')->default(false);          // Aparece no detalhe
            $table->boolean('visible_create')->default(true);         // Aparece no form criar
            $table->boolean('visible_edit')->default(true);           // Aparece no form editar

            // === Grid — Thead (cabeçalho) ===
            $table->string('grid_label')->nullable();                 // Override do label no thead
            $table->string('width_index', 20)->nullable();            // Largura da coluna (100px, 15%, auto)
            $table->integer('grid_order')->default(0);                // Ordem da coluna na grid
            $table->boolean('sortable')->default(false);              // Permite ordenar no grid
            $table->boolean('searchable')->default(false);            // Aparece nos filtros / busca
            $table->string('grid_sticky', 10)->nullable();            // Fixar coluna: null, 'left', 'right'

            // === Grid — Tbody (conteúdo) ===
            $table->string('grid_template')->nullable();              // Combinar campos ({first_name} {surname})
            $table->string('grid_link')->nullable();                  // Link ({show}, {edit}, URL externa)
            $table->string('grid_format')->nullable();                // Máscara livre (DD/MM/YYYY, R$ #.##0,00)
            $table->string('grid_align', 10)->default('left');        // Alinhamento: left, center, right
            $table->integer('grid_max_chars')->nullable();            // Truncar texto + "..."
            $table->boolean('grid_as_image')->default(false);         // Renderizar path como thumbnail
            $table->integer('grid_image_size')->default(32);          // Tamanho fixo (ex: 32 = 32x32px)

            // === Grid — Ações ===
            $table->json('grid_actions')->nullable();                 // JSON de ações customizadas

            // === Controle ===
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->string('origin')->default('system');              // system / custom
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_fields_ui');
    }
};
