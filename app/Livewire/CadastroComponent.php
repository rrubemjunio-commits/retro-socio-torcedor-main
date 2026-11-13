<?php

namespace App\Livewire;

use App\Models\Socio;
use Livewire\Component;

class CadastroComponent extends Component
{
    public ?string $nome = null;

    public ?string $cpf = null;

    public ?string $telefone = null;

    public ?string $email = null;

    public ?string $data_nascimento = null;

    public ?string $plano = null;

    public function mount(?string $planoInicial = null): void
    {
        $this->plano = $planoInicial;
    }

    public function cadastrar()
    {
        $dados = $this->validate([
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

        session()->flash('sucesso', 'Sócio cadastrado com sucesso!');

        return $this->redirectRoute('socios.index');
    }

    public function render()
    {
        return view('livewire.cadastro-component');
    }
}
