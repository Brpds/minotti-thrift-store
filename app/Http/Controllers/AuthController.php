<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){

        $credenciais = $request->all(['email', 'password']);

        //autenticação via api(guards) do email e senha
        $token = auth('api')->attempt($credenciais);

        if($token){ //sucesso de autenticação
            return response()->json(['token' => $token]);
        }else{//erro de user ou senha
            return response()->json(['erro' => 'Usuário ou senha inválido!'], 403);
        }
        
    }

    public function logout(){
        auth('api')->logout();
        return response()->json(['msg' => 'Logout com sucesso!']);
    }

    public function refresh(){
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }

    public function me(){
        return response()->json(auth()->user());
    }
}
