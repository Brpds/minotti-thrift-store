<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriasBase = [
            ['nome' => 'Outros'],
            ['nome' => 'Calçados'],
            ['nome' => 'Roupas'],
        ];

        foreach($categoriasBase as $categoriaBase){
            DB::table('categorias')->insert([
                'nome' => $categoriaBase['nome'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
