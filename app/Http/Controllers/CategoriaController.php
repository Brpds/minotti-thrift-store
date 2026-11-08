<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct(Categoria $categoria)
    {
        $this->categoria = $categoria;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$categorias = [];

        $categoriaRepository = new CategoriaRepository($this->categoria);

        if($request->has('filtro')){
            $categoriaRepository->filtro($request->filtro);
        }
        if($request->has('atributos')){
            $categoriaRepository->selectAtributos($request->atributos);
        }

        return response()->json($categoriaRepository->getResultadoPaginado(4), 200);
        
        /*
        if($request->has('atributos')){
            $atributos = $request->atributos;
        }
        $categoria = $this->categoria->all();
        return $categoria;
        */
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->categoria->rules(), $this->categoria->feedback());

        $categoria = $this->categoria->create([
            'nome' => $request->nome
        ]);

        return response()->json($categoria, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return $categoria;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categoria = $this->categoria->find($id);

        $idCategoriaPadrao = [1, 2, 3];

        if(in_array($categoria->id, $idCategoriaPadrao)){
            return response()->json(['erro' => 'Não é possível atlterar as categorias padrão.'], 400);
        }

        if($categoria === null){
            return response()->json(['erro' => 'Impossível atualizar. Recurso não existe'], 404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas = [];
            
            foreach ($categoria->rules() as $input => $regra) {
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $this->categoria->feedback());
        }else{
            $request->validate($this->categoria->rules(), $this->categoria->feedback());
        }

        $categoria->update($request->all());

        return response()->json($categoria, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /*
     * This function will prevent the default category from being deleted.
     * reason being, whenever a category is to be deleted, it would have
     * deletion prevented by it's children products (fk related). Now,
     * this destroy function will set the products to a default category
     * that can't be deleted, while deleting the parent category
     */
    public function destroy($id)
    {
        $categoria = $this->categoria->find($id);

        $idCategoriaPadrao = [1, 2, 3];

        if($categoria === null){
            return response()->json(['erro' => 'Recurso não existe. Não é possível excluir'], 404);
        }

        if(in_array($categoria->id, $idCategoriaPadrao)){
            return response()->json(['erro' => 'Impossível excluir as categorias padrão.'], 400);
        }

        if($categoria->produto()->exists()){
            $categoria->produto()->update(['categoria_id' => 1]);
        }
        $categoria->delete();

        return response()->json(['msg' => 'Excluído com sucesso!'], 200);
    }

    //função que retorna ao componente SelectSearch a lista de Categorias
    public function lista(Request $request){
        
        $query = $request->get('query', '');

        $listaCategorias = Categoria::query()->when($query, fn($q) => 
            $q->where('nome', 'like', "%{$query}%"))->select('id', 'nome')
            ->limit(50)->get();

        return response()->json($listaCategorias, 200);
    }

    public function publiclist(){
    
        $listaCategorias = Categoria::select('id', 'nome')->get();

        return response()->json($listaCategorias,200);
    }
}
