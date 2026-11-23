<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocioController extends Controller
{
    public function create()
    {
        return view('socios.create');
    }

    public function form(Request $request)
    {
        $plano = in_array($request->query('plano'), ['Bronze', 'Prata', 'Ouro'], true)
            ? $request->query('plano')
            : null;

        return view('socios.form', compact('plano'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'plano' => ['nullable', 'in:Bronze,Prata,Ouro'],
            'nome' => ['required', 'string', 'max:120'],
            'cpf' => ['required', 'string', 'size:11', 'regex:/^[0-9]{11}$/', 'unique:users,cpf'],
            'telefone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'data_nascimento' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nome.required' => 'Informe o nome completo.',
            'cpf.required' => 'Informe o CPF com 11 números, sem pontos ou traço.',
            'cpf.size' => 'O CPF deve ter exatamente 11 números, sem pontos ou traço.',
            'cpf.regex' => 'O CPF deve ter exatamente 11 números, sem pontos ou traço.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'telefone.required' => 'Informe o telefone.',
            'data_nascimento.required' => 'Informe a data de nascimento.',
            'password.required' => 'Informe uma senha.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
        ]);

        DB::transaction(function () use ($dados) {
            User::create([
                'name' => $dados['nome'],
                'email' => $dados['email'],
                'password' => $dados['password'],
                'cpf' => $dados['cpf'],
                'telefone' => $dados['telefone'],
                'data_nascimento' => $dados['data_nascimento'],
                'plano' => $dados['plano'] ?? null,
                'ativo' => true,
                'papel' => 'admin',
            ]);

            if (!empty($dados['plano'])) {
                Socio::create($dados);
            }
        });

        return redirect()->route('socios.index')->with(
            'sucesso',
            !empty($dados['plano'])
                ? 'Cadastro e assinatura realizados com sucesso!'
                : 'Cadastro realizado com sucesso!'
        );
    }

    public function index()
    {
        $socios = Socio::latest()->get();
        $sociosVaziosVisibilidade = $socios->isEmpty() ? '' : 'd-none';
        $usuarios = User::latest()->get();
        $usuariosVaziosVisibilidade = $usuarios->isEmpty() ? '' : 'd-none';
        $categorias = Categoria::withCount('produtos')->orderBy('nome')->get();

        $metricas = [
            'usuarios' => $usuarios->count(),
            'socios' => $socios->count(),
            'bronze' => $socios->where('plano', 'Bronze')->count(),
            'prata' => $socios->where('plano', 'Prata')->count(),
            'ouro' => $socios->where('plano', 'Ouro')->count(),
            'categorias' => $categorias->count(),
        ];

        return view('socios.index', compact(
            'socios',
            'sociosVaziosVisibilidade',
            'usuarios',
            'usuariosVaziosVisibilidade',
            'categorias',
            'metricas'
        ));
    }
}
