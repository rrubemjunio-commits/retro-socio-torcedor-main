<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use Illuminate\Http\Request;

class SocioController extends Controller
{
    public function create()
    {
        return redirect()->route('socios.form');
    }

    public function form(Request $request)
    {
        return view('socios.form');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:120'],
            'cpf' => ['required', 'string', 'size:11', 'regex:/^[0-9]{11}$/', 'unique:socios,cpf'],
            'telefone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
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

        Socio::create($dados);

        return redirect()->route('socios.index')->with('sucesso', 'Sócio cadastrado com sucesso!');
    }

    public function index()
    {
        $socios = Socio::latest()->get();
        $sociosVaziosVisibilidade = $socios->isEmpty() ? '' : 'd-none';

        return view('socios.index', compact('socios', 'sociosVaziosVisibilidade'));
    }
}
