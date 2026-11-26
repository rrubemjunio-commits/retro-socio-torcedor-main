<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PagamentoController extends Controller
{
    private const PLANOS = [
        'Bronze' => 19.90,
        'Prata' => 39.90,
        'Ouro' => 69.90,
    ];

    public function show(string $plano): View
    {
        abort_unless(array_key_exists($plano, self::PLANOS), 404);

        return view('pagamento.index', [
            'plano' => $plano,
            'valor' => self::PLANOS[$plano],
        ]);
    }

    public function confirmar(Request $request, string $plano): RedirectResponse
    {
        abort_unless(array_key_exists($plano, self::PLANOS), 404);

        $request->validate([
            'metodo' => ['required', Rule::in(['cartao', 'pix', 'boleto'])],
        ]);

        $usuario = $request->user();

        DB::transaction(function () use ($usuario, $plano): void {
            $usuario->update(['plano' => $plano]);

            Socio::updateOrCreate(
                ['cpf' => $usuario->cpf],
                [
                    'nome' => $usuario->name,
                    'cpf' => $usuario->cpf,
                    'telefone' => $usuario->telefone,
                    'email' => $usuario->email,
                    'data_nascimento' => $usuario->data_nascimento,
                    'plano' => $plano,
                ]
            );
        });

        return redirect()->route('socios.index')
            ->with('sucesso', 'Assinatura aprovada na simulação! Seu plano foi ativado e você agora é sócio VIP.');
    }
}
