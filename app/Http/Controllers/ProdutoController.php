<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Socio;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $dados = $request->validate([
            'aba' => ['sometimes', 'in:consumo,cupons'],
            'categoria' => ['sometimes', 'integer', 'exists:categorias,id'],
        ]);

        $abaSelecionada = $dados['aba'] ?? 'consumo';
        $categoriaSelecionada = $dados['categoria'] ?? null;
        $categorias = Categoria::orderBy('nome')->get();
        $consulta = Produto::with('categoria')
            ->where('disponivel', true)
            ->orderByDesc('destaque')
            ->orderBy('nome');

        if ($abaSelecionada === 'consumo' && $categoriaSelecionada !== null) {
            $consulta->where('categoria_id', $categoriaSelecionada);
        }

        $produtos = $consulta->get();
        $socioAutenticado = auth()->check()
            && Socio::where('email', auth()->user()->email)->exists();
        $cupons = [
            [
                'titulo' => 'Bebida gelada',
                'descricao' => 'Pra refrescar a torcida.',
                'desconto' => '10% OFF',
                'codigo' => 'BEBIDA10',
                'validade' => 'Até acabar!',
            ],
            [
                'titulo' => 'Combo da torcida',
                'descricao' => 'Lanche + acompanhamento com descontão.',
                'desconto' => 'R$ 8 OFF',
                'codigo' => 'COMBO8',
                'validade' => 'Até acabar!',
            ],
        ];

        return view('produtos.index', compact(
            'produtos',
            'categorias',
            'categoriaSelecionada',
            'abaSelecionada',
            'socioAutenticado',
            'cupons'
        ));
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
