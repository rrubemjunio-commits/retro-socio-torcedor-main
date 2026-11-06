<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Categoria;

Route::get('/', function () {
    $categorias = Categoria::orderBy('nome')->get();

    return view('home', compact('categorias'));
})->name('home');

Route::view('/jogos', 'jogos.index')->name('jogos.index');
Route::get('/ingressos', function () {
    $jogos = [
        [
            'adversario' => 'Náutico',
            'data' => '28 de novembro de 2026',
            'horario' => '16h',
            'estadio' => 'Arena de Pernambuco',
            'inteira' => 40,
            'meia' => 20,
        ],
        [
            'adversario' => 'Santa Cruz',
            'data' => '12 de dezembro de 2026',
            'horario' => '18h30',
            'estadio' => 'Arena de Pernambuco',
            'inteira' => 50,
            'meia' => 25,
        ],
    ];

    return view('ingressos.index', compact('jogos'));
})->name('ingressos.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Cadastro e consulta dos sócios-torcedores.
Route::get('/cadastro', [SocioController::class, 'create'])->name('socios.create');
Route::get('/cadastro/novo', [SocioController::class, 'form'])->name('socios.form');
Route::post('/cadastro', [SocioController::class, 'store'])->name('socios.store');
Route::get('/socios', [SocioController::class, 'index'])->name('socios.index');

// Catálogo de produtos e benefícios para a torcida.
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/cadastro', [ProdutoController::class, 'create'])->name('produtos.create');
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');

// Cadastro e consulta das categorias do catálogo.
Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/categorias/cadastro', [CategoriaController::class, 'create'])->name('categorias.create');
Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
