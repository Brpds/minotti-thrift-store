<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/produtos', function() {
    return view('app.produtos');
})->name('produtos')->middleware('auth');

Route::get('/marcas', function() {
    return view('app.marcas');
})->name('marcas')->middleware('auth');

Route::get('/fornecedores', function() {
    return view('app.fornecedores');
})->name('fornecedores')->middleware('auth');

Route::get('/usuarios', function() {
    return view('app.usuarios');
})->name('usuarios')->middleware('auth');

Route::get('/relatorios', function() {
    return view('app.relatorios');
})->name('relatorios')->middleware('auth');

Route::get('/avaliacoes', function() {
    return view('app.avaliacoes');
})->name('avaliacoes')->middleware('auth');

Route::get('/categorias', function() {
    return view('app.categorias');
})->name('categorias')->middleware('auth');

Route::get('/adicionar', function() {
    return view('app.adicionar');
})->name('adicionar')->middleware('auth');

Route::get('/vitrine', function(){
    return view('app.publicviews.allproducts');
    })->name('vitrine');

Route::get('/vitrine/{produto}', function(){
    return view('app.publicviews.viewproduct');
});

Route::get('/vendaconosco', function(){
    return view('app.publicviews.sellwithus');
})->name('vendaconosco');

Route::get('/sobrenos', function(){
    return view('app.publicviews.aboutus');
})->name('sobrenos');

Route::get('/perguntasfrequentes', function(){
    return view('app.publicviews.faq');
})->name('perguntasfrequentes');