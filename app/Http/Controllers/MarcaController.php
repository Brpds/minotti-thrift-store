<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $marcaRepository = new MarcaRepository($this->marca);
        //$marcas = [];

        if ($request->has('filtro')) {
            $marcaRepository->filtro($request->filtro);
        }
        if($request->has('atributos')){
            $marcaRepository->selectAtributos($request->atributos);
        }

        return response()->json($marcaRepository->getResultadoPaginado(4), 200);

        /*if($request->has('atributos')){
            $atributos = $request->atributos;
            $marcas = $this->marca->selectRaw($atributos)->paginate(4);
        }else{
            $marcas = $this->marca->paginate(4);
        }
        //$marca = $this->marca->all();
        //return  response()->json($this->marca->get(), 200);
        return  response()->json($marcas, 200);*/
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->marca->rules(), $this->marca->feedback());

        $marca = $this->marca->create([
            'nome' => $request->nome,
        ]);

        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'Recurso não encontrado'], 404);
        }
        return response()->json($marca, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(['erro' => 'Impossível atualizar! A marca não existe.'], 404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas = [];
            
            foreach($marca->rules() as $input => $regra) {
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $this->marca->feedback());
        }else{
            $request->validate($this->marca->rules(), $this->marca->feedback());
        }

        //preenchendo a requisição com os dados da request:

        $marca->fill($request->all());

        $marca->save();

        return response()->json($marca, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        
        //A loja DEVERÁ ser a marcaPadraoId. se não for possível que seja o 1, alterá-la de acordo
        $marcaPadraoId = 1;

        //Marca não encontrada
        if($marca === null){
            return response()->json(['erro' => 'A marca não existe.'], 404);
        }

        //Marca padrão que armazenará os produtos marca definida/com marca excluída
        if($marca->id === $marcaPadraoId){
            return response()->json(['erro' => 'Esta marca não pode ser excluída.'], 400);
        }
        
        /*
        *alterará os IDs de marca dos produtos com marca excluída para
        um ID padrão, evitando conflitos de FK. 
        */
        if($marca->produto()->exists()){
            $marca->produto()->update(['marca_id' => $marcaPadraoId]);
        }
        
        $marca->delete();

        return response()->json(['msg' => 'Marca excluída com sucesso!'], 200);

    }

    //função que retorna ao componente SelectSearch a lista de marcas

    public function lista(Request $request){

        $query = $request->get('query', '');

        $listaMarcas = Marca::query()->when($query, fn ($q) =>
            $q->where('nome', 'like', "%{$query}%")
        )->select('id', 'nome')->limit(50)->get();

        return response()->json($listaMarcas, 200);
    }
}
