<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('produtos')->orderBy('nome')->get();
        $categoriasVaziasVisibilidade = $categorias->isEmpty() ? '' : 'd-none';

        return view('categorias.index', compact('categorias', 'categoriasVaziasVisibilidade'));
    }

    public function create()
    {
        $icones = collect(Categoria::iconesBootstrap())
            ->map(fn (string $rotulo, string $nome): array => [
                'nome' => $nome,
                'rotulo' => $rotulo,
                'selectedAttribute' => old('icone') === $nome ? 'selected' : '',
            ])
            ->all();

        return view('categorias.create', compact('icones'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:100'],
            'icone' => ['nullable', Rule::in(array_keys(Categoria::iconesBootstrap()))],
        ], [
            'nome.required' => 'Informe o nome da categoria.',
            'nome.max' => 'O nome da categoria deve ter até 100 caracteres.',
            'icone.in' => 'Escolha um dos ícones disponíveis.',
        ]);

        Categoria::create($dados);

        return redirect()->route('categorias.index')->with('sucesso', 'Categoria cadastrada com sucesso!');
    }
}
