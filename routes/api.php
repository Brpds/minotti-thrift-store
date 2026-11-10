<?php

use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PublicProdutoController;
use App\Http\Controllers\SubscriberController;
use App\Http\Resources\ProdutoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->middleware(['jwt.auth', 'admin:api'])->group(function(){
    // INÍCIO do grupo de rotas para load de opções no formulário
    
    Route::get('/opcoes/status', 'App\Http\Controllers\OpcoesController@configOpcoesStatus');
    Route::get('/opcoes/divisao', 'App\Http\Controllers\OpcoesController@configOpcoesDivisao');
    Route::get('/opcoes/condicao', 'App\Http\Controllers\OpcoesController@configOpcoesCondicao');
    //aplicação moderna de rotas do Laravel abaixo. Recomendado
    Route::get('marcas/list', [App\Http\Controllers\MarcaController::class, 'lista'])->name('api.marcas');
    Route::get('fornecedores/list', 'App\Http\Controllers\FornecedorController@lista')->name('api.fornecedores');
    Route::get('categorias/list', 'App\Http\Controllers\CategoriaController@lista')->name('api.categorias');
    Route::get('tamanhocalcado', [App\Http\Controllers\OpcoesController::class, 'configTamanhoCalcado'])->name('api.tamanhocalcado');
    Route::get('tamanhoroupa', [App\Http\Controllers\OpcoesController::class, 'configTamanhoRoupa'])->name('api.tamanhoroupa');

    // FIM do grupo de rotas para load de opções no formulário
    Route::apiResource('fornecedores', 'App\Http\Controllers\FornecedorController')
        ->parameters(['fornecedores' => 'fornecedor']);
    Route::apiResource('categorias', 'App\Http\Controllers\CategoriaController');
    Route::apiResource('marcas', 'App\Http\Controllers\MarcaController');
    Route::apiResource('produtos', 'App\Http\Controllers\ProdutoController');
});

Route::prefix('v1')->middleware('jwt.auth')->group(function(){
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
});

Route::get('categorias/publiclist', ['App\Http\Controllers\CategoriaController', 'publiclist'])->name('api.categorias.test');

Route::prefix('v1')->group(function(){
    Route::get('vitrine', [App\Http\Controllers\PublicProdutoController::class, 'index']);
})->name('api.public.vitrine');

Route::prefix('v1')->group(function(){
    Route::get('destaque', [App\Http\Controllers\PublicProdutoController::class, 'destaque']);
})->name('api.public.destaque');

Route::prefix('v1')->group(function(){
    Route::get('vitrine/{id}', [App\Http\Controllers\PublicProdutoController::class, 'show']);
})->name('api.public.singleproduct');

Route::post('subscribers', [SubscriberController::class, 'store'])->name('subscribers');

Route::post('login', 'App\Http\Controllers\AuthController@login');
