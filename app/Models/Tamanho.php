<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamanho extends Model
{
    protected $table = 'tamanhos';
    
    protected $fillable = ['categoria', 'nome', 'valor_numerico'];

    public function rules(){
        return [
            'categoria' => 'required|in:calcado,roupa',
            'nome' => 'max:20',
            'valor_numerico' => 'decimal:1|max:5'
        ];

    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'categoria.in' => 'Escolher entre os valores pré-definidos',
            'nome.max' => 'Máximo de 20 caracteres.',
            'valor_numerico.decimal' => 'Máximo de 1 casa decimal',
            'valor_numerico.max' => 'Máximo de 5 caracteres'
        ];
    }
}
