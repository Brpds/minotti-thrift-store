<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['nome'];

    public function rules(){
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:2|max:100',
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'nome.unique' => 'O nome da marca já existe.',
            'nome.min' => 'Mínimo de 2 caracteres.',
            'nome.max' => 'Nome não pode exceder 100 caracteres',
        ];
    }


    public function produto(){
        return $this->hasMany('App\Models\Produto');
    }
}
