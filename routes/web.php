<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/produtos', function() {
    return view('app.produtos');
})->name('produtos')->middleware(['auth', 'admin:web']);

Route::get('/marcas', function() {
    return view('app.marcas');
})->name('marcas')->middleware(['auth', 'admin:web']);

Route::get('/fornecedores', function() {
    return view('app.fornecedores');
})->name('fornecedores')->middleware(['auth', 'admin:web']);

Route::get('/usuarios', function() {
    return view('app.usuarios');
})->name('usuarios')->middleware(['auth', 'admin:web']);

Route::get('/relatorios', function() {
    return view('app.relatorios');
})->name('relatorios')->middleware(['auth', 'admin:web']);

Route::get('/avaliacoes', function() {
    return view('app.avaliacoes');
})->name('avaliacoes')->middleware(['auth', 'admin:web']);

Route::get('/categorias', function() {
    return view('app.categorias');
})->name('categorias')->middleware(['auth', 'admin:web']);

Route::get('/adicionar', function() {
    return view('app.adicionar');
})->name('adicionar')->middleware(['auth', 'admin:web']);

Route::get('/vitrine', function(){
    return view('app.publicViews.allProducts');
    })->name('vitrine');

Route::get('/vitrine/{produto}', function(){
    return view('app.publicViews.viewProduct');
});

Route::get('/vendaconosco', function(){
    return view('app.publicViews.sellWithUs');
})->name('vendaconosco');

Route::get('/sobrenos', function(){
    return view('app.publicViews.aboutUs');
})->name('sobrenos');

Route::get('/perguntasfrequentes', function(){
    return view('app.publicViews.faq');
})->name('perguntasfrequentes');
