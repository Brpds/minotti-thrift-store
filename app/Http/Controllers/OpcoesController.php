<?php

namespace App\Http\Controllers;

use App\Models\Tamanho;
use Illuminate\Http\Request;

class OpcoesController extends Controller
{
    public function configOpcoesStatus(){

        /**
         * quando houver necessidade de adicionar mais opções de status, as alterações
         * devem ser feitas aqui, na migration (create_produtos_table é a base, guie-se 
         * por lá para criar uma nova) e adicionar o novo status nas rules(regras) do 
         * Produto.php(model)
         */
        $status = [
            ['nome' => 'disponivel'],
            ['nome' => 'vendido'],
            ['nome' => 'pendente']
        ];

        return response()->json($status, 200);
    }

    /**
         * quando houver necessidade de adicionar mais opções de divisão, as alterações
         * devem ser feitas aqui, na migration (create_produtos_table é a base, guie-se 
         * por lá para criar uma nova) e adicionar a nova divisão nas rules(regras) do 
         * Produto.php(model)
         */

    public function configOpcoesDivisao(){

        $divisao = [
            ['nome' => 'fixo' ],
            ['nome' => 'percentual']
        ];

        return response()->json($divisao, 200);
    }

    public function configOpcoesCondicao(){
        $condicao = [
            ['nome' => 'Nova'],
            ['nome' => 'Seminova']
        ];

        return response()->json($condicao, 200);
    }

    public function configTamanhoCalcado(){

        $tamanhoCalcado = Tamanho::select('id','nome')->where('categoria', 'calcado')->get();

        return response()->json($tamanhoCalcado, 200);
    }

    public function configTamanhoRoupa(){

        $tamanhosRoupa = Tamanho::select('id','nome')->where('categoria', 'roupa')->get();;

        return response()->json($tamanhosRoupa, 200);
    }
}
