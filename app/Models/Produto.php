<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Produto extends Model
{
    protected $fillable = [
        'nome', 
        'categoria_id', 
        'descricao', 
        'marca_id', 
        'valor_venda', 
        'tipo_divisao', 
        'fornecedor_id', 
        'status', 
        'parte_loja', 
        'imagem', 
        'tamanho', 
        'condicao', 
        'destaque',
        'etiqueta'
    ];

    //valores padrão são definidos aqui
    protected $attributes = [
        'status' => 'pendente' //default value for status
    ];

    public function rules(){
        return [
            //'nome' => 'required|unique:produtos,nome,'.$this->id.'|min:3|max:120',
            'nome' => 'required|min:3|max:120',
            'categoria_id' => 'required|exists:categorias,id',
            'descricao' => 'required|max:255',
            'marca_id' => 'required|exists:marcas,id',
            /* 
                valor de venda e outros números editados de decimal para integer para facilitar storage e cálculos
                agora os valores são em centavos, facilitando cálculos
            */
            'valor_venda' => 'required|integer|gt:0|max:10000000',
            'tipo_divisao' => 'required|in:percentual,fixo',
            'fornecedor_id' => 'required|exists:fornecedores,id',
            'status' => 'required|in:disponivel,vendido,pendente',
            #parteLoja alterado de decimal para integer
            'parte_loja' => 'required|integer|lte:valor_venda|gt:0|max:10000000',
            'imagem' => 'nullable|file|mimes:png,jpg,jpeg',
            'tamanho' => 'max:10',
            'condicao' => 'required',
            'etiqueta' => 'required|max:10|',Rule::unique('produtos','etiqueta')->ignore($this->id),
            #'etiqueta' => 'required|max:10|unique:produtos,etiqueta',
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'categoria_id.exists' => 'A categoria não existe.',
            'descricao.max' => 'A descrição não pode exceder 255 caracteres.',
            'marca_id.exists' => 'A marca não existe.',
            'valor_venda.integer' => 'O valor deve ser do tipo número.',
            'valor_venda.gt' => 'O valor de venda deve ser maior que R$ 0,00.',
            'tipo_divisao.in' => 'Divisão só pode ser Percentual ou Fixo.',
            'fornecedor_id.exists' => 'O fornecedor não existe.',
            'status.in' => 'O status só pode ser Disponível, Vendido ou Pendente',
            'parte_loja.integer' => 'O valor deve ser do tipo número.',
            'parte_loja.lte' => 'A parte da loja deve ser menor ou igual ao valor de venda.',
            'parte_loja.gt' => 'A parte da loja deve ser maior que R$ 0,00.',
            'imagem.mimes' => 'O arquivo deve ser nos formatos PNG ou JPG',
            'imagem.file' => 'O arquivo deve ser do tipo imagem.',
            'tamanho.max' => 'O tamanho tem um máximo de 10 caracteres.',
            'etiqueta.max' => 'O limite de tamanho das etiquetas é 10',
            'etiqueta.unique' => 'Etiqueta já cadastrada. Confira o valor digitado.'
        ];
    }

    //FKs
    public function marca(){
        return $this->belongsTo('App\Models\Marca');
    }

    public function fornecedor(){
        return $this->belongsTo('App\Models\Fornecedor');
    }

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }
}
