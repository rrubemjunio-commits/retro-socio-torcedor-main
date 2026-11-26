<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IngressoController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\SocioController;
use App\Http\Middleware\RedirectGuestsToRegistration;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Socio;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categorias = Categoria::orderBy('nome')->get();
    $categoriasVaziasVisibilidade = $categorias->isEmpty() ? '' : 'd-none';
    $beneficiosDisponiveis = Produto::where('disponivel', true)->count();
    $sociosCadastrados = Socio::whereNotNull('plano')->count();

    return view('home', compact(
        'categorias',
        'categoriasVaziasVisibilidade',
        'beneficiosDisponiveis',
        'sociosCadastrados'
    ));
})->name('home');

Route::view('/jogos', 'jogos.index')->name('jogos.index');
Route::get('/ingressos', [IngressoController::class, 'index'])->name('ingressos.index');
Route::post('/ingressos', [IngressoController::class, 'store'])
    ->middleware(RedirectGuestsToRegistration::class)
    ->name('ingressos.store');

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
Route::get('/pagamento/{plano}', [PagamentoController::class, 'show'])
    ->middleware(RedirectGuestsToRegistration::class)
    ->name('pagamento.show');
Route::post('/pagamento/{plano}/confirmar', [PagamentoController::class, 'confirmar'])
    ->middleware(RedirectGuestsToRegistration::class)
    ->name('pagamento.confirmar');

Route::middleware('auth')->group(function () {
    Route::get('/socios', [SocioController::class, 'index'])->name('socios.index');

    // Catálogo de produtos e benefícios para a torcida.
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produtos/cadastro', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');

    // Cadastro e consulta das categorias do catálogo.
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/categorias/cadastro', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
});
