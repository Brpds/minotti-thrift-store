<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoupaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tamanhos = [
            ['categoria'=> 'roupa', 'nome' => 'RN' ],
            ['categoria'=> 'roupa', 'nome' => 'P' ],
            ['categoria'=> 'roupa', 'nome' => 'M' ],
            ['categoria'=> 'roupa', 'nome' => 'G' ],
            ['categoria'=> 'roupa', 'nome' => '1' ],
            ['categoria'=> 'roupa', 'nome' => '2' ],
            ['categoria'=> 'roupa', 'nome' => '3' ],
            ['categoria'=> 'roupa', 'nome' => '4' ],
            ['categoria'=> 'roupa', 'nome' => '6' ],
            ['categoria'=> 'roupa', 'nome' => '8' ],
            ['categoria'=> 'roupa', 'nome' => '10' ],
            ['categoria'=> 'roupa', 'nome' => '12' ],
        ];

        foreach ($tamanhos as $tamanho) {
            DB::table('tamanhos')->insert([
                'categoria'   => 'roupa',
                'nome'      => $tamanho['nome'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}