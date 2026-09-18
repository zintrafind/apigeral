<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Proposta;
use App\Models\ItemProposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropostaController extends Controller
{
    /**
     * Listar as solicitações de troca do usuário logado.
     */
    public function index(Request $request)
    {
        $usuario = $request->user();

        $propostas = Proposta::with([
            'solicitante',
            'destinatario',
            'itens.produto'
        ])
        ->where(function ($query) use ($usuario) {
            $query->where('id_solicitante', $usuario->id_usuario)
                  ->orWhere('id_destinatario', $usuario->id_usuario);
        })
        ->orderByDesc('created_at')
        ->get();

        return response()->json([
            'propostas' => $propostas
        ]);
    }

    /**
     * Criar uma nova solicitação de troca.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_produto_desejado' => 'required|integer|exists:tb_produto,id_produto',
            'id_produto_oferecido' => 'required|integer|exists:tb_produto,id_produto',
        ]);

        $usuario = $request->user();

        // Busca os dois produtos
        $produtoDesejado = Product::find($validatedData['id_produto_desejado']);
        $produtoOferecido = Product::find($validatedData['id_produto_oferecido']);

        // Verifica se os produtos existem
        if (!$produtoDesejado || !$produtoOferecido) {
            return response()->json([
                'message' => 'Um ou mais produtos não foram encontrados.'
            ], 404);
        }

        // Não pode trocar um produto por ele mesmo
        if ($produtoDesejado->id_produto === $produtoOferecido->id_produto) {
            return response()->json([
                'message' => 'O produto desejado e o produto oferecido devem ser diferentes.'
            ], 422);
        }

        // O produto desejado deve pertencer a outro usuário
        if ($produtoDesejado->id_usuario === $usuario->id_usuario) {
            return response()->json([
                'message' => 'Você não pode solicitar uma troca pelo seu próprio produto.'
            ], 422);
        }

        // O produto oferecido deve pertencer ao usuário logado
        if ($produtoOferecido->id_usuario !== $usuario->id_usuario) {
            return response()->json([
                'message' => 'O produto oferecido deve pertencer ao usuário logado.'
            ], 403);
        }

     // Verifica se o usuário já possui uma solicitação pendente
// com a mesma combinação de produto desejado e produto oferecido.
$solicitacaoExistente = Proposta::where(
    'id_solicitante',
    $usuario->id_usuario
)
->where(
    'id_destinatario',
    $produtoDesejado->id_usuario
)
->where('st_troca', 'P')
->whereHas('itens', function ($query) use ($produtoDesejado) {
    $query->where('id_produto', $produtoDesejado->id_produto)
          ->where('tp_item', 'D');
})
->whereHas('itens', function ($query) use ($produtoOferecido) {
    $query->where('id_produto', $produtoOferecido->id_produto)
          ->where('tp_item', 'O');
})
->exists();

if ($solicitacaoExistente) {
    return response()->json([
        'message' => 'Você já possui uma solicitação pendente com estes mesmos produtos.'
    ], 422);
}
        // Os dois produtos precisam estar disponíveis
        if ($produtoDesejado->st_status !== 'A') {
            return response()->json([
                'message' => 'O produto desejado não está disponível para troca.'
            ], 422);
        }

        if ($produtoOferecido->st_status !== 'A') {
            return response()->json([
                'message' => 'O produto oferecido não está disponível para troca.'
            ], 422);
        }

        /*
         * Cria a proposta e seus itens em uma única transação.
         */
        $proposta = DB::transaction(function () use (
            $usuario,
            $produtoDesejado,
            $produtoOferecido
        ) {
            // Cria a proposta
            $proposta = Proposta::create([
                'id_solicitante' => $usuario->id_usuario,
                'id_destinatario' => $produtoDesejado->id_usuario,
                'st_troca' => 'P',
                'ds_local_troca' => null,
            ]);

            // Produto oferecido pelo solicitante
            ItemProposta::create([
                'id_proposta' => $proposta->id_proposta,
                'id_produto' => $produtoOferecido->id_produto,
                'tp_item' => 'O',
            ]);

            // Produto desejado do destinatário
            ItemProposta::create([
                'id_proposta' => $proposta->id_proposta,
                'id_produto' => $produtoDesejado->id_produto,
                'tp_item' => 'D',
            ]);

            return $proposta;
        });

        // Retorna a proposta completa
        $proposta->load([
            'solicitante',
            'destinatario',
            'itens.produto'
        ]);

        return response()->json([
            'message' => 'Solicitação de troca criada com sucesso!',
            'proposta' => $proposta
        ], 201);
    }

    /**
     * Aceitar ou recusar uma proposta.
     */
    public function status(Request $request, $id)
    {
        $validatedData = $request->validate([
            'st_troca' => 'required|in:A,R',
        ]);

        $usuario = $request->user();

        $proposta = Proposta::find($id);

        // Verifica se a proposta existe
        if (!$proposta) {
            return response()->json([
                'message' => 'Proposta não encontrada.'
            ], 404);
        }

        // Somente o destinatário pode aceitar ou recusar
        if ($proposta->id_destinatario !== $usuario->id_usuario) {
            return response()->json([
                'message' => 'Somente o destinatário pode aceitar ou recusar esta proposta.'
            ], 403);
        }

        // Só é possível responder uma proposta pendente
        if ($proposta->st_troca !== 'P') {
            return response()->json([
                'message' => 'Esta proposta não está pendente.'
            ], 422);
        }

        $proposta->update([
            'st_troca' => $validatedData['st_troca']
        ]);

        $proposta->load([
            'solicitante',
            'destinatario',
            'itens.produto'
        ]);

        $mensagem = $validatedData['st_troca'] === 'A'
            ? 'Proposta aceita com sucesso!'
            : 'Proposta recusada com sucesso!';

        return response()->json([
            'message' => $mensagem,
            'proposta' => $proposta
        ], 200);
    }

   /**
 * Finalizar uma troca aceita.
 */
public function finalizar(Request $request, $id)
{
    $usuario = $request->user();

    $proposta = Proposta::with('itens.produto')->find($id);

    // Verifica se a proposta existe
    if (!$proposta) {
        return response()->json([
            'message' => 'Proposta não encontrada.'
        ], 404);
    }

    // Verifica se o usuário participa da troca
    if (
        $proposta->id_solicitante !== $usuario->id_usuario &&
        $proposta->id_destinatario !== $usuario->id_usuario
    ) {
        return response()->json([
            'message' => 'Você não participa desta troca.'
        ], 403);
    }

    // A troca precisa estar aceita
    if ($proposta->st_troca !== 'A') {
        if ($proposta->st_troca === 'F') {
            return response()->json([
                'message' => 'Esta troca já foi concluída.',
                'proposta' => $proposta
            ], 422);
        }

        return response()->json([
            'message' => 'A troca precisa estar aceita para ser finalizada.'
        ], 422);
    }

    /*
     * Registra a confirmação do usuário que clicou em "Finalizar".
     */
    if ($proposta->id_solicitante === $usuario->id_usuario) {

        $proposta->update([
            'st_confirmacao_solicitante' => 'S'
        ]);

    } elseif ($proposta->id_destinatario === $usuario->id_usuario) {

        $proposta->update([
            'st_confirmacao_destinatario' => 'S'
        ]);
    }

    /*
     * Recarrega a proposta para verificar se os dois
     * usuários já confirmaram.
     */
    $proposta->refresh();

    /*
     * A troca só é realmente finalizada quando
     * os dois usuários confirmarem.
     */
    if (
        $proposta->st_confirmacao_solicitante === 'S' &&
        $proposta->st_confirmacao_destinatario === 'S'
    ) {

        DB::transaction(function () use ($proposta) {

            // Finaliza a proposta
            $proposta->update([
                'st_troca' => 'F'
            ]);

            // Marca os produtos como trocados
            foreach ($proposta->itens as $item) {

                $produto = Product::find($item->id_produto);

                if ($produto) {
                    $produto->update([
                        'st_status' => 'T'
                    ]);
                }
            }
        });

        $proposta->refresh();

        $proposta->load([
            'solicitante',
            'destinatario',
            'itens.produto'
        ]);

        return response()->json([
            'message' => 'Troca concluída com sucesso! Os dois usuários confirmaram a finalização.',
            'proposta' => $proposta,
            'troca_concluida' => true
        ], 200);
    }

    /*
     * Apenas um dos usuários confirmou.
     */
    $proposta->load([
        'solicitante',
        'destinatario',
        'itens.produto'
    ]);

    return response()->json([
        'message' => 'Sua confirmação foi registrada. A troca será concluída quando o outro usuário também confirmar.',
        'proposta' => $proposta,
        'troca_concluida' => false
    ], 200);
}

}