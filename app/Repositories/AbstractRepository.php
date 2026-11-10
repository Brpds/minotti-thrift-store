<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

abstract class AbstractRepository{
    protected array $allowedAttributes = [];
    
    public function __construct(Model $model){

        $this->model = $model;
    
    }

    public function selectAtributosRegistrosRelacionados($atributos){
            $this->model = $this->model->with($atributos);
            //a query está sendo montada
    }
    
    public function filtro($filtros){
        if (!is_string($filtros) || $filtros === '') {
            throw ValidationException::withMessages(['filtro' => 'Filtro inválido.']);
        }

        $filtros = explode(';', $filtros);

        foreach ($filtros as $key => $condicao) {
            $c = explode(':', $condicao, 3);

            if (count($c) !== 3 ||
                !in_array($c[0], $this->allowedAttributes, true) ||
                !in_array($c[1], ['=', '!=', '<>', '<', '<=', '>', '>=', 'like', 'not like'], true)) {
                throw ValidationException::withMessages(['filtro' => 'Campo, operador ou formato de filtro inválido.']);
            }

            $this->model = $this->model->where($c[0], $c[1], $c[2]);
            //a query está sendo montada
        }
    }

    public function selectAtributos($atributos){
        if (!is_string($atributos) || $atributos === '') {
            throw ValidationException::withMessages(['atributos' => 'Seleção de campos inválida.']);
        }

        $atributos = array_map('trim', explode(',', $atributos));

        if (array_diff($atributos, $this->allowedAttributes)) {
            throw ValidationException::withMessages(['atributos' => 'Seleção de campos inválida.']);
        }

        $this->model = $this->model->select($atributos);
    }

    public function getResultado(){

        return $this->model->get();
    }

    public function getResultadoPaginado($registrosPorPagina){
        return $this->model->paginate($registrosPorPagina);
    }
}

?>
