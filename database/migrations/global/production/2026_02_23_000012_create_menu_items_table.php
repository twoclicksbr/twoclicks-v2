<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->nullOnDelete();
            $table->string('label', 100);
            $table->string('icon', 100)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('route', 100)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('target', 10)->default('_self');
            $table->string('layout', 20)->nullable()->comment('grid, tabs, list, link');
            $table->string('scope', 20)->comment('global, platform, tenant');
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
