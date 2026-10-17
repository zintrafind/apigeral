<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Proposta;
use App\Models\ItemProposta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropostaController extends Controller
{
    /**
     * Listar as propostas do usuário logado.
     *
     * Com ?para_chat=1, retorna uma versão reduzida
     * para a tela de conversas (muito mais rápida).
     */
    public function index(Request $request)
    {
        $usuario = $request->user();

        $consulta = Proposta::query()
            ->where(function ($query) use ($usuario) {
                $query
                    ->where('id_solicitante', $usuario->id_usuario)
                    ->orWhere('id_destinatario', $usuario->id_usuario);
            });

        /*
        |--------------------------------------------------------------------------
        | CONSULTA PARA O CHAT (OTIMIZADA)
        |--------------------------------------------------------------------------
        */
        if ($request->boolean('para_chat')) {
            $propostas = $consulta
                ->select([
                    'id_proposta',
                    'id_solicitante',
                    'id_destinatario',
                    'st_troca',
                    'created_at',
                    'updated_at',
                ])
                ->whereIn('st_troca', ['A', 'F'])
                ->with([
                    'solicitante:id_usuario,nm_usuario,ds_foto_perfil',
                    'destinatario:id_usuario,nm_usuario,ds_foto_perfil',
                ])
                ->orderByDesc('created_at')
                ->orderByDesc('id_proposta')
                ->get();

            // 🚀 Busca TODAS as últimas mensagens em 1 única query
            $ids = $propostas->pluck('id_proposta')->all();

            $ultimas = collect();
            if (!empty($ids)) {
                $ultimas = DB::table('tb_mensagem')   // ⚠️ AJUSTE O NOME AQUI
                    ->whereIn('id_proposta', $ids)
                    ->orderByDesc('created_at')
                    ->orderByDesc('id_mensagem')
                    ->get()
                    ->groupBy('id_proposta')
                    ->map(fn ($msgs) => $msgs->first());
            }

            // Anexa a última mensagem em cada proposta
            $propostas->each(function ($p) use ($ultimas) {
                $p->ultima_mensagem = $ultimas->get($p->id_proposta);
            });

            return response()->json([
                'propostas' => $propostas,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CONSULTA COMPLETA DAS TROCAS
        |--------------------------------------------------------------------------
        */
        $propostas = $consulta
            ->with([
                'solicitante',
                'destinatario',
                'itens.produto.images',
            ])
            ->orderByDesc('created_at')
            ->orderByDesc('id_proposta')
            ->get();

        return response()->json([
            'propostas' => $propostas,
        ]);
    }


    /**
     * Criar uma nova solicitação de troca.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_produto_desejado' =>
                'required|integer|exists:tb_produto,id_produto',

            'ids_produtos_oferecidos' =>
                'required|array|min:1',

            'ids_produtos_oferecidos.*' =>
                'required|integer|distinct|exists:tb_produto,id_produto',
        ]);

        $usuario = $request->user();

        if ($usuario->st_perfil_disponivel === 'I') {
            return response()->json([
                'message' => 'Você está indisponível para trocas. Altere a disponibilidade do seu perfil para solicitar uma troca.',
            ], 422);
        }

        $idsProdutosOferecidos = array_map(
            'intval',
            $validatedData['ids_produtos_oferecidos']
        );

        $produtoDesejado = Product::find(
            $validatedData['id_produto_desejado']
        );

        $produtosOferecidos = Product::whereIn(
            'id_produto',
            $idsProdutosOferecidos
        )->get();

        if (!$produtoDesejado || $produtosOferecidos->count() !== count($idsProdutosOferecidos)) {
            return response()->json([
                'message' =>
                    'Um ou mais produtos não foram encontrados.',
            ], 404);
        }

        if (
            $produtoDesejado->id_usuario ===
            $usuario->id_usuario
        ) {
            return response()->json([
                'message' =>
                    'Você não pode solicitar uma troca pelo seu próprio produto.',
            ], 422);
        }

        if (
            $produtoDesejado->user?->st_perfil_disponivel === 'I'
        ) {
            return response()->json([
                'message' => 'Este usuário está indisponível para trocas no momento.',
            ], 422);
        }

        foreach ($produtosOferecidos as $produtoOferecido) {
            if ((int) $produtoOferecido->id_produto === (int) $produtoDesejado->id_produto) {
                return response()->json([
                    'message' =>
                        'O produto desejado e o produto oferecido devem ser diferentes.',
                ], 422);
            }

            if ((int) $produtoOferecido->id_usuario !== (int) $usuario->id_usuario) {
                return response()->json([
                    'message' =>
                        'Todos os produtos oferecidos devem pertencer ao usuário logado.',
                ], 403);
            }

            if ($produtoOferecido->st_status !== 'A') {
                return response()->json([
                    'message' =>
                        'Todos os produtos oferecidos devem estar disponíveis para troca.',
                ], 422);
            }
        }

        $idsProdutosOferecidosOrdenados = collect($idsProdutosOferecidos)
            ->unique()
            ->sort()
            ->values()
            ->all();

        $propostasPendentesMesmoProdutoDesejado = Proposta::query()
            ->where('id_solicitante', $usuario->id_usuario)
            ->where('st_troca', 'P')
            ->whereHas('itens', function ($query) use ($produtoDesejado) {
                $query
                    ->where('id_produto', $produtoDesejado->id_produto)
                    ->where('tp_item', 'D');
            })
            ->with(['itens' => function ($query) {
                $query
                    ->select('id_item_proposta', 'id_proposta', 'id_produto')
                    ->where('tp_item', 'O');
            }])
            ->get();

        $solicitacaoExistente = $propostasPendentesMesmoProdutoDesejado->contains(
            function ($proposta) use ($idsProdutosOferecidosOrdenados) {
                $idsExistentesOrdenados = $proposta->itens
                    ->pluck('id_produto')
                    ->map(fn ($idProduto) => (int) $idProduto)
                    ->unique()
                    ->sort()
                    ->values()
                    ->all();

                return $idsExistentesOrdenados === $idsProdutosOferecidosOrdenados;
            }
        );

        if ($solicitacaoExistente) {
            return response()->json([
                'message' =>
                    'Você já possui uma solicitação pendente com estes mesmos produtos.',
            ], 422);
        }

        if ($produtoDesejado->st_status !== 'A') {
            return response()->json([
                'message' =>
                    'O produto desejado não está disponível para troca.',
            ], 422);
        }

        $proposta = DB::transaction(function () use (
            $usuario,
            $produtoDesejado,
            $produtosOferecidos
        ) {
            $proposta = Proposta::create([
                'id_solicitante' =>
                    $usuario->id_usuario,

                'id_destinatario' =>
                    $produtoDesejado->id_usuario,

                'st_troca' => 'P',

                'ds_local_troca' => null,
            ]);

            foreach ($produtosOferecidos as $produtoOferecido) {
                ItemProposta::create([
                    'id_proposta' =>
                        $proposta->id_proposta,

                    'id_produto' =>
                        $produtoOferecido->id_produto,

                    'tp_item' => 'O',
                ]);
            }

            ItemProposta::create([
                'id_proposta' =>
                    $proposta->id_proposta,

                'id_produto' =>
                    $produtoDesejado->id_produto,

                'tp_item' => 'D',
            ]);

            return $proposta;
        });

        $proposta->load([
            'solicitante',
            'destinatario',
            'itens.produto.images',
        ]);

        return response()->json([
            'message' =>
                'Solicitação de troca criada com sucesso!',

            'proposta' => $proposta,
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

        if (!$proposta) {
            return response()->json([
                'message' =>
                    'Proposta não encontrada.',
            ], 404);
        }

        if (
            $proposta->id_destinatario !==
            $usuario->id_usuario
        ) {
            return response()->json([
                'message' =>
                    'Somente o destinatário pode aceitar ou recusar esta proposta.',
            ], 403);
        }

        if ($proposta->st_troca !== 'P') {
            return response()->json([
                'message' =>
                    'Esta proposta não está pendente.',
            ], 422);
        }

        if ($validatedData['st_troca'] === 'A') {
            $participanteIndisponivel = User::query()
                ->whereIn('id_usuario', [
                    $proposta->id_solicitante,
                    $proposta->id_destinatario,
                ])
                ->where('st_perfil_disponivel', 'I')
                ->exists();

            if ($participanteIndisponivel) {
                return response()->json([
                    'message' => 'Não é possível aceitar esta proposta enquanto um dos usuários estiver indisponível para trocas.',
                ], 422);
            }

            $proposta->load('itens.produto');

            $produtoIndisponivel = $proposta->itens->contains(
                fn ($item) => !$item->produto || $item->produto->st_status !== 'A'
            );

            if ($produtoIndisponivel) {
                return response()->json([
                    'message' =>
                        'Não é possível aceitar esta proposta porque um dos produtos não está mais disponível.',
                ], 422);
            }
        }

        $proposta->update([
            'st_troca' =>
                $validatedData['st_troca'],
        ]);

        $proposta->load([
            'solicitante',
            'destinatario',
            'itens.produto.images',
        ]);

        $mensagem =
            $validatedData['st_troca'] === 'A'
                ? 'Proposta aceita com sucesso!'
                : 'Proposta recusada com sucesso!';

        return response()->json([
            'message' => $mensagem,
            'proposta' => $proposta,
        ], 200);
    }


    /**
     * Cancelar uma solicitação de troca pendente pelo solicitante.
     */
    public function cancelar(Request $request, $id)
    {
        $usuario = $request->user();
        $proposta = Proposta::find($id);

        if (!$proposta) {
            return response()->json([
                'message' => 'Proposta não encontrada.',
            ], 404);
        }

        if ($proposta->id_solicitante !== $usuario->id_usuario) {
            return response()->json([
                'message' => 'Somente o solicitante pode cancelar esta proposta.',
            ], 403);
        }

        if ($proposta->st_troca !== 'P') {
            return response()->json([
                'message' => 'Somente propostas pendentes podem ser canceladas.',
            ], 422);
        }

        $proposta->update([
            'st_troca' => 'C',
        ]);

        $proposta->load([
            'solicitante',
            'destinatario',
            'itens.produto.images',
        ]);

        return response()->json([
            'message' => 'Solicitação cancelada com sucesso!',
            'proposta' => $proposta,
        ], 200);
    }


    /**
     * Registrar a confirmação de finalização.
     */
    public function finalizar(Request $request, $id)
    {
        $usuario = $request->user();

        $proposta = Proposta::with(
            'itens.produto.images'
        )->find($id);

        if (!$proposta) {
            return response()->json([
                'message' =>
                    'Proposta não encontrada.',
            ], 404);
        }

        if (
            $proposta->id_solicitante !==
                $usuario->id_usuario
            &&
            $proposta->id_destinatario !==
                $usuario->id_usuario
        ) {
            return response()->json([
                'message' =>
                    'Você não participa desta troca.',
            ], 403);
        }

        if ($proposta->st_troca !== 'A') {
            if ($proposta->st_troca === 'F') {
                return response()->json([
                    'message' =>
                        'Esta troca já foi concluída.',

                    'proposta' =>
                        $proposta,
                ], 422);
            }

            return response()->json([
                'message' =>
                    'A troca precisa estar aceita para ser finalizada.',
            ], 422);
        }

        $participanteIndisponivel = User::query()
            ->whereIn('id_usuario', [
                $proposta->id_solicitante,
                $proposta->id_destinatario,
            ])
            ->where('st_perfil_disponivel', 'I')
            ->exists();

        if ($participanteIndisponivel) {
            return response()->json([
                'message' => 'Não é possível finalizar esta troca enquanto um dos usuários estiver indisponível para trocas.',
            ], 422);
        }

        $produtoIndisponivel = $proposta->itens->contains(
            fn ($item) => !$item->produto || $item->produto->st_status !== 'A'
        );

        if ($produtoIndisponivel) {
            return response()->json([
                'message' =>
                    'Não é possível finalizar esta troca porque um dos produtos não está mais disponível.',
            ], 422);
        }

        if (
            $proposta->id_solicitante ===
            $usuario->id_usuario
        ) {
            $proposta->update([
                'st_confirmacao_solicitante' => 'S',
            ]);
        } elseif (
            $proposta->id_destinatario ===
            $usuario->id_usuario
        ) {
            $proposta->update([
                'st_confirmacao_destinatario' => 'S',
            ]);
        }

        $proposta->refresh();

        if (
            $proposta->st_confirmacao_solicitante === 'S'
            &&
            $proposta->st_confirmacao_destinatario === 'S'
        ) {
            DB::transaction(function () use ($proposta) {
                $proposta->update([
                    'st_troca' => 'F',
                ]);

                foreach ($proposta->itens as $item) {
                    $produto = Product::find(
                        $item->id_produto
                    );

                    if ($produto) {
                        $produto->update([
                            'st_status' => 'T',
                        ]);
                    }
                }
            });

            $proposta->refresh();

            $proposta->load([
                'solicitante',
                'destinatario',
                'itens.produto.images',
            ]);

            return response()->json([
                'message' =>
                    'Troca concluída com sucesso! Os dois usuários confirmaram a finalização.',

                'proposta' =>
                    $proposta,

                'troca_concluida' =>
                    true,
            ], 200);
        }

        $proposta->load([
            'solicitante',
            'destinatario',
            'itens.produto.images',
        ]);

        return response()->json([
            'message' =>
                'Sua confirmação foi registrada. A troca será concluída quando o outro usuário também confirmar.',

            'proposta' =>
                $proposta,

            'troca_concluida' =>
                false,
        ], 200);
    }
}