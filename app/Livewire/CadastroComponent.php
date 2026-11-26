<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CadastroComponent extends Component
{
    public ?string $nome = null;

    public ?string $cpf = null;

    public ?string $telefone = null;

    public ?string $email = null;

    public ?string $data_nascimento = null;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public function cadastrar()
    {
        $dados = $this->validate([
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

        $user = User::create([
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

        Auth::login($user);
        session()->regenerate();
        session()->flash('sucesso', 'Conta criada! Escolha um plano e aprove a assinatura para se tornar sócio.');

        return $this->redirectRoute('socios.create');
    }

    public function render()
    {
        return view('livewire.cadastro-component');
    }
}
