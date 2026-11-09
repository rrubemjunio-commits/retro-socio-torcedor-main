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
        $categoriaTodosActiveClass = $categoriaSelecionada === null ? 'active' : '';
        $filtrosCategoriasClass = $categorias->isNotEmpty() ? '' : 'd-none';
        $categorias->each(function (Categoria $categoria) use ($categoriaSelecionada): void {
            $categoria->setAttribute(
                'activeClass',
                (int) $categoriaSelecionada === $categoria->id ? 'active' : ''
            );
            $categoria->setAttribute(
                'ariaCurrent',
                (int) $categoriaSelecionada === $categoria->id ? 'page' : 'false'
            );
        });
        $consulta = Produto::with('categoria')
            ->where('disponivel', true)
            ->orderByDesc('destaque')
            ->orderBy('nome');

        if ($abaSelecionada === 'consumo' && $categoriaSelecionada !== null) {
            $consulta->where('categoria_id', $categoriaSelecionada);
        }

        $produtos = $consulta->get();
        $produtos->each(function (Produto $produto): void {
            $produto->setAttribute('imagemUrl', $produto->imagem ? asset($produto->imagem) : '');
            $produto->setAttribute('imagemVisibilidade', $produto->imagem ? '' : 'd-none');
            $produto->setAttribute(
                'placeholderVisibilidade',
                $produto->imagem ? 'd-none' : ''
            );
            $produto->setAttribute(
                'categoriaVisibilidade',
                $produto->categoria ? '' : 'd-none'
            );
            $produto->setAttribute('categoriaNome', $produto->categoria?->nome ?? '');
            $produto->setAttribute('iconeCategoria', $produto->categoria?->iconeBootstrap() ?? 'bag');
            $produto->setAttribute(
                'destaqueVisibilidade',
                $produto->destaque ? '' : 'd-none'
            );
            $produto->setAttribute(
                'descricaoVisibilidade',
                $produto->descricao ? '' : 'd-none'
            );
        });
        $socioAutenticado = auth()->check()
            && Socio::where('email', auth()->user()->email)->exists();
        $consumoVisibilidade = $abaSelecionada === 'consumo' ? '' : 'd-none';
        $cuponsVisibilidade = $abaSelecionada === 'cupons' ? '' : 'd-none';
        $cuponsSocioVisibilidade = $socioAutenticado ? '' : 'd-none';
        $cuponsVisitanteVisibilidade = $socioAutenticado ? 'd-none' : '';
        $loginLinkVisibilidade = auth()->guest() ? '' : 'd-none';
        $produtosVaziosVisibilidade = $produtos->isEmpty() ? '' : 'd-none';
        $classeAbaConsumo = $abaSelecionada === 'consumo' ? 'active' : '';
        $ariaAbaConsumo = $abaSelecionada === 'consumo' ? 'page' : 'false';
        $classeAbaCupons = $abaSelecionada === 'cupons' ? 'active' : '';
        $ariaAbaCupons = $abaSelecionada === 'cupons' ? 'page' : 'false';
        $cupons = $socioAutenticado ? [
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
        ] : [];

        return view('produtos.index', compact(
            'produtos',
            'categorias',
            'categoriaSelecionada',
            'abaSelecionada',
            'socioAutenticado',
            'cupons',
            'filtrosCategoriasClass',
            'consumoVisibilidade',
            'cuponsVisibilidade',
            'cuponsSocioVisibilidade',
            'cuponsVisitanteVisibilidade',
            'loginLinkVisibilidade',
            'produtosVaziosVisibilidade',
            'categoriaTodosActiveClass',
            'classeAbaConsumo',
            'ariaAbaConsumo',
            'classeAbaCupons',
            'ariaAbaCupons'
        ));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();
        $categorias->each(function (Categoria $categoria): void {
            $categoria->setAttribute(
                'selectedAttribute',
                old('categoria_id') == $categoria->id ? 'selected' : ''
            );
        });
        $destaqueCheckedAttribute = old('destaque', true) ? 'checked' : '';
        $disponivelCheckedAttribute = old('disponivel', true) ? 'checked' : '';

        return view('produtos.create', compact(
            'categorias',
            'destaqueCheckedAttribute',
            'disponivelCheckedAttribute'
        ));
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
