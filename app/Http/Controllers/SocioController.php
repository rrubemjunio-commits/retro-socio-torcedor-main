<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use Illuminate\Http\Request;

class SocioController extends Controller
{
    public function create()
    {
        return view('socios.create');
    }

    public function form(Request $request)
    {
        $planos = ['Bronze', 'Prata', 'Ouro'];
        $planoSelecionado = $request->query('plano');

        if (! in_array($planoSelecionado, $planos, true)) {
            $planoSelecionado = null;
        }

        return view('socios.form', compact('planoSelecionado'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:120'],
            'cpf' => ['required', 'string', 'size:11', 'unique:socios,cpf'],
            'telefone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'data_nascimento' => ['required', 'date'],
            'plano' => ['required', 'in:Bronze,Prata,Ouro'],
        ], [
            'nome.required' => 'Informe o nome completo.',
            'cpf.required' => 'Informe o CPF com 11 números, sem pontos ou traço.',
            'cpf.size' => 'O CPF deve ter exatamente 11 números, sem pontos ou traço.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'telefone.required' => 'Informe o telefone.',
            'data_nascimento.required' => 'Informe a data de nascimento.',
            'plano.required' => 'Escolha um plano.',
        ]);

        Socio::create($dados);

        return redirect()->route('socios.index')->with('sucesso', 'Sócio cadastrado com sucesso!');
    }

    public function index()
    {
        $socios = Socio::latest()->get();
        return view('socios.index', compact('socios'));
    }
}
