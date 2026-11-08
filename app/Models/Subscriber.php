<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'subscribers';

    protected $fillable = ['email'];

    public function rules(){
        return [
            'email' => 'required|email|max:255|unique:subscribers,email'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo é obrigatório.',
            'email.email' => 'Digite um email válido',
            'email.max' => 'O máximo é de 255 caracteres.',
            'email.unique' => 'O email já está cadastrado.'
        ];
    }

}
