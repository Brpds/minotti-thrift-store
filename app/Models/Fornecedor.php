<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';

    protected $fillable = ['nome', 'cpf', 'endereco', 'numero', 'cep', 'referencia', 'telefone', 'chave_pix'];
    
    public function rules(){
        return [
            'nome' => 'required|unique:fornecedores,nome,'.$this->id.'|min:3|max:150',
            'cpf' => 'required|unique:fornecedores,cpf,'.$this->id.'|size:11',
            'endereco' => 'required|min:3|max:250',
            'numero' => 'required|min:1|max:10',
            'cep' => 'required|size:8',
            'referencia' => 'max:150',
            'telefone' => 'required|max:20',
            'chave_pix' => 'required|unique:fornecedores,chave_pix,'.$this->id.'|max:100'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => ':attribute já cadastrado.',
            'cpf.size' => 'CPF tem 11 dígitos. Somente números.',
            'numero.min' => 'Número deve conter no mínimo 1 dígito.',
            'numero.max' => 'Número deve conter no máximo 10 caracteres.',
            'cep.size' => 'CEP só pode conter 8 dígitos. Somente números.',
            'referencia.max' => 'Ponto de referência só pode ter 150 caracteres.',
            'telefone.max' => 'Telefone pode ter no máximo 20 caracteres.',
            'chave_pix.unique' => 'Chave Pix já cadastrada.',
            'chave_pix.max' => 'Chave Pix não pode exceder 100 caracteres'
        ];
    }

    public function produto(){
        return $this->hasMany('App\Models\Produto');
    }
}
