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
        Schema::table('produtos', function(Blueprint $table){
            #$table->unsignedBigInteger('tamanho')->nullable();

            $table->char('tamanho', 2)->nullable();

            //foreign keys
            /*$table->foreign('tamanho')
                  ->references('id')
                  ->on('tamanhos')
                  ->onDelete('set null');*/
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function(Blueprint $table){
            //$table->dropForeign(['tamanho']);
            $table->dropColumn('tamanho');
        });
    }
};
