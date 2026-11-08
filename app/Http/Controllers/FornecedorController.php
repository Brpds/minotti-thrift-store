<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Repositories\FornecedorRepository;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function __construct(Fornecedor $fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $fornecedorRepository = new FornecedorRepository($this->fornecedor);

        if($request->has('filtro')){
            $fornecedorRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){
            $fornecedorRepository->selectAtributos($request->atributos);
        }

        return response()->json($fornecedorRepository->getResultadoPaginado(4), 200);
        
        
        /*$fornecedores = [];

        if($request->has('atributos')){
            $atributos = $request->atributos;
            $fornecedores = $this->fornecedor->selectRaw($atributos)->paginate(5);
        }else{
            $fornecedores = $this->fornecedor->paginate(5);
        }
        //$fornecedor = $this->fornecedor->all();
        return response()->json($fornecedores, 200);*/
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validará as entradas conforme as regras no model fornecedor
        $request->validate($this->fornecedor->rules(), $this->fornecedor->feedback());

        //cria o registro no banco
        $fornecedor = $this->fornecedor->create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'cep' => $request->cep,
            'referencia' => $request->referencia,
            'telefone' => $request->telefone,
            'chave_pix' => $request->chave_pix,
        ]);

        return response()->json($fornecedor, 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Fornecedor $fornecedor)
    {
        return $fornecedor;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fornecedor = $this->fornecedor->find($id);

        if($fornecedor === null){
            return response()->json(['erro' => 'Impossível atualizar recurso! Fornecedor não existe'], 404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas = [];
            
            foreach ($fornecedor->rules() as $input => $regra) {
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }


            $request->validate($regrasDinamicas, $this->fornecedor->feedback());
        }
        else{
            $request->validate($this->fornecedor->rules(), $this->fornecedor->feedback());
        }
        $fornecedor->update($request->all());
        return response()->json($fornecedor, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fornecedor = $this->fornecedor->find($id);

        //A loja DEVERÁ ser o fornecedorPadraoId. se não for possível que seja o 1, alterá-lo de acordo
        $fornecedorPadraoId = 1;

        if($fornecedor === null){
            return response()->json(['erro' => 'O fornecedor não existe.'], 404);
        }

        //não permite que o fornecedor padrão definido seja excluído
        /*
         * o fornecedor padrão armazenará os produtos que não possuírem
         * fornecedor definido
        */
        if($fornecedor->id === $fornecedorPadraoId){
            return response()->json(['erro' => 'Este fornecedor não pode ser excluído.'], 400);
        }

        /*
         *alterará os IDs de fornecedor dos produtos com fornecedor excluído para
         um ID padrão, evitando conflitos de FK. 
        */
        if($fornecedor->produto()->exists()){
            $fornecedor->produto()->update(['fornecedor_id' => $fornecedorPadraoId]);
        }

        $fornecedor->delete();

        return response()->json(['msg' => 'Fornecedor Excluído com sucesso!'], 200);
    }

    //função que retorna ao componente SelectSearch a lista de fornecedores
    public function lista(Request $request){
        
        $query = $request->get('query', '');

        $listaFornecedores = Fornecedor::query()->when($query, fn($q)=>
            $q->where('nome', 'like', "%{$query}%"))->select('id', 'nome')
            ->limit(50)->get();

        return response()->json($listaFornecedores, 200);
    }
}
