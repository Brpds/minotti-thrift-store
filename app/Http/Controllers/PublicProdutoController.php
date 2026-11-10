<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;

class PublicProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::where('status', 'disponivel');

        if($request->filled('nome')){
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        //filtros opcionais
        if($request->filled('idade')){
            $query->where('tamanho', $request->idade);
        }

        if($request->filled('categoria')){
            $query->where('categoria_id', $request->categoria);
        }

        if($request->filled('tamanho')){
            $query->where('tamanho', $request->tamanho);
        }

        if($request->filled('condicao')){
            $query->where('condicao', $request->condicao);
        }

        $request->validate([
            'nome' => 'nullable|string|max:255',
            'categoria' => 'nullable|integer',
            'tamanho' => 'nullable|string|max:10',
            'condicao' => 'nullable|string|max:50',
        ]);

        $produtos = $query->paginate(6)->withQueryString();

        return ProdutoResource::collection($produtos);
    }

    public function show($id){
        
        $produto = Produto::where('status', 'disponivel')
        ->findOrFail($id);
        
        return new ProdutoResource($produto);
    }

    public function destaque(){

        $destaques = Produto::where('destaque', true)
        ->where('status', 'disponivel')
        ->take(4)
        ->get();

        if($destaques->count() < 4){
            $extra = Produto::where('destaque', false)
            ->where('status', 'disponivel')
            ->inRandomOrder()
            ->take(4 - $destaques->count())
            ->get();

            $destaques = $destaques->merge($extra);
        }

        return ProdutoResource::collection($destaques);
    }
}
