<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

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
            'icone' => ['nullable', 'string', 'max:60', 'regex:/\A[a-z0-9]+(?:-[a-z0-9]+)*\z/'],
        ], [
            'nome.required' => 'Informe o nome da categoria.',
            'nome.max' => 'O nome da categoria deve ter até 100 caracteres.',
            'icone.regex' => 'Informe o nome do ícone Bootstrap, como tag-fill ou trophy.',
        ]);

        Categoria::create($dados);

        return redirect()->route('categorias.index')->with('sucesso', 'Categoria cadastrada com sucesso!');
    }
}
