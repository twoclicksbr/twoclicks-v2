<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_actions', function (Blueprint $table) {
            $table->id();
            $table->string('name');                                   // Label visível (ex: "Visualizar")
            $table->string('slug')->unique();                         // Identificador técnico (ex: "show")
            $table->string('icon')->nullable();                       // Ícone KTIcon (ex: "ki-outline ki-eye")
            $table->string('color')->default('btn-light');            // Cor do botão
            $table->string('method')->default('GET');                 // GET, POST, PUT, DELETE, PATCH
            $table->string('route_suffix')->nullable();               // Sufixo da rota (ex: "show", "edit", "destroy")
            $table->boolean('confirmation')->default(false);          // Exige confirmação antes de executar
            $table->string('confirmation_message')->nullable();       // Mensagem do confirm
            $table->string('target')->default('_self');               // _self ou _blank
            $table->string('tooltip')->nullable();                    // Texto ao passar o mouse
            $table->string('side')->default('left');                  // left = visível, right = dropdown
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_actions');
    }
};
