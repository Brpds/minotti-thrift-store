<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalcadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tamanhos = [
            ['nome' => '17', 'valor_numerico' => 17],
            ['nome' => '18', 'valor_numerico' => 18],
            ['nome' => '19', 'valor_numerico' => 19],
            ['nome' => '20', 'valor_numerico' => 20],
            ['nome' => '21', 'valor_numerico' => 21],
            ['nome' => '22', 'valor_numerico' => 22],
            ['nome' => '23', 'valor_numerico' => 23],
            ['nome' => '24', 'valor_numerico' => 24],
            ['nome' => '25', 'valor_numerico' => 25],
            ['nome' => '26', 'valor_numerico' => 26],
            ['nome' => '27', 'valor_numerico' => 27],
            ['nome' => '28', 'valor_numerico' => 28],
            ['nome' => '29', 'valor_numerico' => 29],
            ['nome' => '30', 'valor_numerico' => 30],
            ['nome' => '31', 'valor_numerico' => 31],
            ['nome' => '32', 'valor_numerico' => 32],
            ['nome' => '33', 'valor_numerico' => 33],
            ['nome' => '34', 'valor_numerico' => 34],
        ];

    foreach ($tamanhos as $tamanho) {
        DB::table('tamanhos')->insert([
            'categoria'        => 'calcado',
            'nome'           => $tamanho['nome'],
            'valor_numerico'   => $tamanho['valor_numerico'],
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
    }
}
