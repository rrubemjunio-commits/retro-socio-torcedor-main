<?php

namespace App\Http\Controllers;

use App\Models\ReservaIngresso;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IngressoController extends Controller
{
    private const JOGOS = [
        'nautico' => [
            'adversario' => 'Náutico',
            'data' => '28 de novembro de 2026',
            'data_iso' => '2026-11-28',
            'horario' => '16h',
            'estadio' => 'Arena de Pernambuco',
            'inteira' => 40,
            'meia' => 20,
        ],
        'santa-cruz' => [
            'adversario' => 'Santa Cruz',
            'data' => '12 de dezembro de 2026',
            'data_iso' => '2026-12-12',
            'horario' => '18h30',
            'estadio' => 'Arena de Pernambuco',
            'inteira' => 50,
            'meia' => 25,
        ],
    ];

    public function index()
    {
        return view('ingressos.index', ['jogos' => self::JOGOS]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'jogo' => ['required', Rule::in(array_keys(self::JOGOS))],
            'tipo' => ['required', Rule::in(['inteira', 'meia'])],
            'quantidade' => ['required', 'integer', 'min:1', 'max:6'],
        ], [
            'jogo.in' => 'Selecione um jogo válido.',
            'tipo.in' => 'Selecione um tipo de ingresso válido.',
            'quantidade.min' => 'A quantidade mínima é 1 ingresso.',
            'quantidade.max' => 'É possível reservar até 6 ingressos por vez.',
        ]);

        $jogo = self::JOGOS[$dados['jogo']];
        $valorUnitario = $jogo[$dados['tipo']];

        ReservaIngresso::create([
            'user_id' => $request->user()?->id,
            'adversario' => $jogo['adversario'],
            'data_jogo' => $jogo['data_iso'],
            'horario' => $jogo['horario'],
            'estadio' => $jogo['estadio'],
            'tipo' => $dados['tipo'],
            'quantidade' => $dados['quantidade'],
            'valor_unitario' => $valorUnitario,
            'valor_total' => $valorUnitario * $dados['quantidade'],
        ]);

        return redirect()->route('ingressos.index')
            ->with('sucesso', 'Reserva registrada! Esta é uma demonstração: nenhum pagamento foi processado.');
    }
}
