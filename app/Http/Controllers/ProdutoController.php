<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function __construct(Produto $produto)
    {
        $this->produto = $produto;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produtoRepository = new ProdutoRepository($this->produto);
        //$produtos = [];

        if($request->has('filtro')){
            $produtoRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){
            $produtoRepository->selectAtributos($request->atributos);
        }

        return response()->json($produtoRepository->getResultadoPaginado(4), 200);

        /*if($request->has('atributos')){
            $atributos = $request->atributos;
            $produtos = $this->produto->selectRaw($atributos)->paginate(4);
        }else{
            $produtos = $this->produto->paginate(4);
        }
        //$produto = $this->produto->all();
        return response()->json($produtos, 200);*/
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!$request->has('status') || $request->status === '' || $request->status === null){
            $request->merge(['status' => 'pendente']);
        }

        $request->validate(array_merge($this->produto->rules(), [
            'imagem' => 'required|file|mimes:png,jpg,jpeg',
        ]), $this->produto->feedback());

        $imagem_urn = Storage::disk('public')->putFile('imagens/produtos', $request->file('imagem'));
        abort_if($imagem_urn === false, 500, 'Não foi possível salvar a imagem.');

        try {
            $produto = $this->produto->create([
                'nome' => $request->nome,
                'categoria_id' => $request->categoria_id,
                'descricao' => $request->descricao,
                'marca_id' => $request->marca_id,
                'valor_venda' => $request->valor_venda,
                'tipo_divisao' => $request->tipo_divisao,
                'fornecedor_id' => $request->fornecedor_id,
                'status' => $request->status,
                'parte_loja' => $request->parte_loja,
                'imagem' => $imagem_urn,
                'tamanho' => $request->tamanho,
                'condicao' => $request->condicao,
                'etiqueta' => $request->etiqueta,
            ]);
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($imagem_urn);
            throw $exception;
        }

        return response()->json($produto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        /*
            with será responsável por trazer com os registros os itens
            passados que tenham relação com o produto
        */
        $produto = $this->produto->with('marca','fornecedor', 'categoria')->find($id);

        if($produto === null){
            return response()->json(['erro' => 'Recurso não existe'], 404);
        }
        return response()->json($produto, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produto = $this->produto->find($id);

        if($produto === null){
            return response()->json(['erro' => 'Impossível atualizar. O produto não existe'], 404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas = [];
            
            foreach ($produto->rules() as $input => $regra) {
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }


            $request->validate($regrasDinamicas, $this->produto->feedback());
        }else{
            $request->validate($this->produto->rules(), $this->produto->feedback());
        }

         $dados = $request->except('imagem');

        $imagemAnterior = $produto->imagem;
        $imagemPath = null;

        if ($request->hasFile('imagem')) {
            $imagemPath = Storage::disk('public')->putFile('imagens/produtos', $request->file('imagem'));
            abort_if($imagemPath === false, 500, 'Não foi possível salvar a imagem.');

            // Inject stored path into data
            $dados['imagem'] = $imagemPath;
        }

        try {
            $produto->update($dados);
        } catch (\Throwable $exception) {
            if ($imagemPath !== null) {
                Storage::disk('public')->delete($imagemPath);
            }
            throw $exception;
        }

        if ($imagemPath !== null && $imagemAnterior) {
            Storage::disk('public')->delete($imagemAnterior);
        }

        /*$imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/produtos', 'public');

        $produto->update($request->all());*/
        return response()->json($produto, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produto = $this->produto->find($id);

        if($produto === null){
            return response()->json(['erro' => 'Impossível excluir. Recurso não existe!'], 404);
        }

        $produto->delete();
        Storage::disk('public')->delete($produto->imagem);
        return response()->json(['msg' => 'Excluído com sucesso!'], 200);
    }
}
