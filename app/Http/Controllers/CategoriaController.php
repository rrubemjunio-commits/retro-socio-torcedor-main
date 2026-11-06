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

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
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
