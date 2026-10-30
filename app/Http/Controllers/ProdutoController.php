<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $dados = $request->validate([
            'categoria' => ['sometimes', 'integer', 'exists:categorias,id'],
        ]);

        $categoriaSelecionada = $dados['categoria'] ?? null;
        $categorias = Categoria::orderBy('nome')->get();
        $consulta = Produto::with('categoria')
            ->where('disponivel', true)
            ->orderByDesc('destaque')
            ->orderBy('nome');

        if ($categoriaSelecionada !== null) {
            $consulta->where('categoria_id', $categoriaSelecionada);
        }

        $produtos = $consulta->get();

        return view('produtos.index', compact('produtos', 'categorias', 'categoriaSelecionada'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('produtos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'categoria_id' => ['nullable', 'exists:categorias,id'],
            'nome' => ['required', 'string', 'max:100'],
            'descricao' => ['nullable', 'string'],
            'valor' => ['required', 'numeric', 'min:0'],
            'imagem' => ['nullable', 'string', 'max:255'],
        ], [
            'categoria_id.exists' => 'Selecione uma categoria válida.',
            'nome.required' => 'Informe o nome do produto ou benefício.',
            'valor.required' => 'Informe o valor.',
            'valor.numeric' => 'O valor deve ser numérico.',
            'valor.min' => 'O valor não pode ser negativo.',
        ]);

        $dados['destaque'] = $request->boolean('destaque');
        $dados['disponivel'] = $request->boolean('disponivel');

        Produto::create($dados);

        return redirect()->route('produtos.index')->with('sucesso', 'Produto ou benefício cadastrado com sucesso!');
    }
}
