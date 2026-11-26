<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\ReservaIngresso;
use App\Models\Socio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocioController extends Controller
{
    public function create()
    {
        return view('socios.create');
    }

    public function form()
    {
        return view('socios.form');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
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
                'plano' => null,
                'ativo' => true,
                'papel' => 'admin',
            ]);

            Socio::create([
                'nome' => $dados['nome'],
                'cpf' => $dados['cpf'],
                'telefone' => $dados['telefone'],
                'email' => $dados['email'],
                'data_nascimento' => $dados['data_nascimento'],
                'password' => $dados['password'],
                'plano' => null,
            ]);
        });

        return redirect()->route('socios.index')->with('sucesso', 'Cadastro realizado com sucesso!');
    }

    public function index()
    {
        $socios = Socio::latest()->get();
        $sociosVaziosVisibilidade = $socios->isEmpty() ? '' : 'd-none';
        $usuarios = User::latest()->get();
        $usuariosVaziosVisibilidade = $usuarios->isEmpty() ? '' : 'd-none';
        $categorias = Categoria::withCount('produtos')->orderBy('nome')->get();
        $ingressos = ReservaIngresso::with('user')->latest()->get();

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
            'ingressos',
            'categorias',
            'metricas'
        ));
    }
}
