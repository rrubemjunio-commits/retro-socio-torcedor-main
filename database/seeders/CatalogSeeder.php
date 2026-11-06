<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $catalogo = [
            'Bebidas' => [
                ['Água mineral', 'Água gelada para acompanhar a partida.', 5.00, true],
                ['Refrigerante', 'Lata gelada para curtir cada lance.', 8.00, false],
                ['Suco natural', 'Suco preparado na hora.', 10.00, false],
            ],
            'Lanches' => [
                ['Hambúrguer Retrô', 'Hambúrguer artesanal com queijo e molho da casa.', 28.00, true],
                ['Hot dog da torcida', 'Pão macio, salsicha e acompanhamentos clássicos.', 22.00, false],
            ],
            'Acompanhamentos' => [
                ['Batata frita', 'Porção crocante para dividir com a torcida.', 16.00, true],
                ['Mandioca frita', 'Porção dourada e temperada.', 18.00, false],
            ],
        ];
        $icones = [
            'Bebidas' => 'cup-straw',
            'Lanches' => 'egg-fried',
            'Acompanhamentos' => 'basket2',
        ];

        foreach ($catalogo as $nomeCategoria => $itens) {
            $categoria = Categoria::firstOrCreate(
                ['nome' => $nomeCategoria],
                ['icone' => $icones[$nomeCategoria]]
            );

            foreach ($itens as [$nome, $descricao, $valor, $destaque]) {
                Produto::firstOrCreate(
                    ['categoria_id' => $categoria->id, 'nome' => $nome],
                    [
                        'descricao' => $descricao,
                        'valor' => $valor,
                        'imagem' => null,
                        'destaque' => $destaque,
                        'disponivel' => true,
                    ]
                );
            }
        }
    }
}
