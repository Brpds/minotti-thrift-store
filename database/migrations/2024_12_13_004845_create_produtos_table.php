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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('fornecedor_id');
            $table->unsignedBigInteger('marca_id');
            $table->string('nome', 150);
            $table->string('descricao', 255);
            $table->decimal('valor_venda', 10, 2);
            $table->enum('tipo_divisao', ['percentual', 'fixo']);
            $table->enum('status', ['disponivel', 'vendido', 'pendente'])->default('pendente');
            $table->decimal('parte_loja', 10, 2);
            $table->timestamps();

            //foreign keys:
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            $table->foreign('marca_id')->references('id')->on('marcas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('produtos');
        Schema::enableForeignKeyConstraints();
    }
};
