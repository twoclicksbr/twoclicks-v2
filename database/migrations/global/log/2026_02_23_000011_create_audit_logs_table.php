<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');                    // Usuário que executou a ação
            $table->string('action');                                  // insert, update, delete
            $table->string('table_name');                              // Tabela afetada
            $table->unsignedBigInteger('record_id');                  // ID do registro afetado
            $table->json('old_values')->nullable();                   // Dados antes da alteração
            $table->json('new_values')->nullable();                   // Dados depois da alteração
            $table->integer('status_code');                            // 200, 404, 500, etc.
            $table->string('ip_address')->nullable();                 // IP do cliente
            $table->string('user_agent')->nullable();                 // Browser/app
            $table->timestamp('created_at')->useCurrent();            // Sem updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
