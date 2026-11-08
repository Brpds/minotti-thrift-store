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
        Schema::table('fornecedores', function(Blueprint $table){
            $table->string('numero', 10);
            $table->string('cep', 8);
            $table->string('referencia', 150);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('fornecedores', ['numero', 'cep', 'referencia']);
    }
};
