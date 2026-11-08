<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tamanhos', function (Blueprint $table) {
            $table->id();
            $table->enum('categoria', ['calcado', 'roupa']);
            $table->string('nome', 20);
            $table->decimal('valor_numerico', 5, 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tamanhos');
    }
};
