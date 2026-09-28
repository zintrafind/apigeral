<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // ============================================================
    // UC52 - GERENCIAR USUÁRIOS
    // ============================================================


    // ------------------------------------------------------------
    // LISTAR USUÁRIOS
    // ------------------------------------------------------------

    public function listarUsuarios()
    {
        $usuarios = DB::table('tb_usuario')
            ->select(
                'id_usuario',
                'nm_usuario',
                'email',
                'tp_usuario',
                'st_usuario',
                'st_email_verificado',
                'ds_foto_perfil',
                'ds_usuario',
                'created_at',
                'updated_at'
            )
            ->orderBy('nm_usuario', 'asc')
            ->get();

        return response()->json(
            $usuarios,
            200
        );
    }


    // ------------------------------------------------------------
    // VISUALIZAR DADOS COMPLETOS DO USUÁRIO
    // ------------------------------------------------------------

    public function visualizarUsuarioAdmin($id)
    {
        $usuario = DB::table('tb_usuario')
            ->select(
                'id_usuario',
                'nm_usuario',
                'email',
                'tp_usuario',
                'st_usuario',
                'st_email_verificado',
                'ds_foto_perfil',
                'ds_usuario',
                'created_at',
                'updated_at'
            )
            ->where(
                'id_usuario',
                $id
            )
            ->first();

        if (!$usuario) {

            return response()->json([
                'message' =>
                    'Usuário não encontrado.'
            ], 404);
        }

        // Quantidade de anúncios publicados pelo usuário
        $usuario->total_anuncios = DB::table('tb_produto')
            ->where(
                'id_usuario',
                $id
            )
            ->count();

        // Quantidade de propostas em que o usuário participou
        $usuario->total_trocas = DB::table('tb_proposta')
            ->where(function ($query) use ($id) {

                $query
                    ->where(
                        'id_solicitante',
                        $id
                    )
                    ->orWhere(
                        'id_destinatario',
                        $id
                    );

            })
            ->count();

        return response()->json(
            $usuario,
            200
        );
    }


    // ------------------------------------------------------------
    // EDITAR USUÁRIO
    // ------------------------------------------------------------

    public function editarUsuarioAdmin(Request $request, $id)
    {
        $usuario = DB::table('tb_usuario')
            ->where(
                'id_usuario',
                $id
            )
            ->first();

        if (!$usuario) {

            return response()->json([
                'message' =>
                    'Usuário não encontrado.'
            ], 404);
        }

        $dadosValidados = $request->validate([

            'nm_usuario' => [
                'required',
                'string',
                'max:100'
            ],

            'email' => [
                'required',
                'email',
                'max:100',

                Rule::unique(
                    'tb_usuario',
                    'email'
                )->ignore(
                    $id,
                    'id_usuario'
                )
            ],

            'tp_usuario' => [
                'required',
                'string',
                'size:1'
            ],

            'ds_usuario' => [
                'nullable',
                'string'
            ]

        ]);

        DB::table('tb_usuario')
            ->where(
                'id_usuario',
                $id
            )
            ->update([

                'nm_usuario' =>
                    $dadosValidados['nm_usuario'],

                'email' =>
                    $dadosValidados['email'],

                'tp_usuario' =>
                    $dadosValidados['tp_usuario'],

                'ds_usuario' =>
                    $dadosValidados['ds_usuario'] ?? null,

                'updated_at' =>
                    now()

            ]);

        $usuarioAtualizado = DB::table('tb_usuario')
            ->select(
                'id_usuario',
                'nm_usuario',
                'email',
                'tp_usuario',
                'st_usuario',
                'st_email_verificado',
                'ds_foto_perfil',
                'ds_usuario',
                'created_at',
                'updated_at'
            )
            ->where(
                'id_usuario',
                $id
            )
            ->first();

        return response()->json([

            'message' =>
                'Usuário atualizado com sucesso!',

            'usuario' =>
                $usuarioAtualizado

        ], 200);
    }


    // ------------------------------------------------------------
    // BLOQUEAR / DESBLOQUEAR USUÁRIO
    // ------------------------------------------------------------
    // A = Ativo
    // B = Bloqueado
    // ------------------------------------------------------------

    public function alterarStatusUsuarioAdmin($id)
    {
        $usuario = DB::table('tb_usuario')
            ->where(
                'id_usuario',
                $id
            )
            ->first();

        if (!$usuario) {

            return response()->json([
                'message' =>
                    'Usuário não encontrado.'
            ], 404);
        }

        /*
        ------------------------------------------------------------
        Se estiver bloqueado, volta para ativo.
        Caso contrário, fica bloqueado.
        ------------------------------------------------------------
        */

        if ($usuario->st_usuario === 'B') {

            $novoStatus = 'A';

        } else {

            $novoStatus = 'B';

        }

        DB::table('tb_usuario')
            ->where(
                'id_usuario',
                $id
            )
            ->update([

                'st_usuario' =>
                    $novoStatus,

                'updated_at' =>
                    now()

            ]);

        // Se o usuário foi bloqueado,
        // encerra todas as sessões dele
        if ($novoStatus === 'B') {

            DB::table('personal_access_tokens')
                ->where(
                    'tokenable_id',
                    $id
                )
                ->delete();

        }

        $mensagem =
            $novoStatus === 'B'
                ? 'Usuário bloqueado com sucesso!'
                : 'Usuário desbloqueado com sucesso!';

        return response()->json([

            'message' =>
                $mensagem,

            'st_usuario' =>
                $novoStatus

        ], 200);
    }


    // ------------------------------------------------------------
    // EXCLUIR USUÁRIO
    // ------------------------------------------------------------

    public function excluirUsuario($id)
    {
        $usuario = DB::table('tb_usuario')
            ->where(
                'id_usuario',
                $id
            )
            ->first();

        if (!$usuario) {

            return response()->json([
                'message' =>
                    'Usuário não encontrado.'
            ], 404);
        }

        try {

            DB::beginTransaction();

            /*
            --------------------------------------------------------
            Exclui registros relacionados ao usuário antes de
            excluir o próprio usuário.

            Isso é necessário porque algumas tabelas possuem
            chaves estrangeiras sem ON DELETE CASCADE.
            --------------------------------------------------------
            */

            // Notificações
            DB::table('tb_notificacao')
                ->where(
                    'id_usuario',
                    $id
                )
                ->delete();

            // Histórico de interação
            DB::table('tb_historico_interacao')
                ->where(
                    'id_usuario',
                    $id
                )
                ->delete();

            // Denúncias feitas pelo usuário
            DB::table('tb_denuncia')
                ->where(
                    'id_usuario',
                    $id
                )
                ->delete();

            // Avaliações feitas pelo usuário
            DB::table('tb_avaliacao')
                ->where(
                    'id_usuario',
                    $id
                )
                ->delete();

            // Favoritos
            DB::table('tb_favorito')
                ->where(
                    'id_usuario',
                    $id
                )
                ->delete();

            // Mensagens enviadas pelo usuário
            DB::table('tb_mensagem')
                ->where(
                    'id_usuario',
                    $id
                )
                ->delete();

            /*
            --------------------------------------------------------
            Busca propostas em que o usuário participou.
            --------------------------------------------------------
            */

            $propostas = DB::table('tb_proposta')
                ->where(
                    'id_solicitante',
                    $id
                )
                ->orWhere(
                    'id_destinatario',
                    $id
                )
                ->pluck(
                    'id_proposta'
                );

            if ($propostas->isNotEmpty()) {

                // Mensagens relacionadas às propostas
                DB::table('tb_mensagem')
                    ->whereIn(
                        'id_proposta',
                        $propostas
                    )
                    ->delete();

                // Itens das propostas
                DB::table('tb_item_proposta')
                    ->whereIn(
                        'id_proposta',
                        $propostas
                    )
                    ->delete();

                // Propostas
                DB::table('tb_proposta')
                    ->whereIn(
                        'id_proposta',
                        $propostas
                    )
                    ->delete();
            }

            /*
            --------------------------------------------------------
            Produtos pertencentes ao usuário.

            tb_produto possui ON DELETE CASCADE em relação ao
            usuário, mas fazemos a limpeza das relações que podem
            impedir a exclusão dos produtos.
            --------------------------------------------------------
            */

            $produtos = DB::table('tb_produto')
                ->where(
                    'id_usuario',
                    $id
                )
                ->pluck(
                    'id_produto'
                );

            if ($produtos->isNotEmpty()) {

                DB::table('tb_historico_interacao')
                    ->whereIn(
                        'id_produto',
                        $produtos
                    )
                    ->delete();

                DB::table('tb_denuncia')
                    ->whereIn(
                        'id_produto',
                        $produtos
                    )
                    ->delete();

                DB::table('tb_avaliacao')
                    ->whereIn(
                        'id_produto',
                        $produtos
                    )
                    ->delete();

                DB::table('tb_favorito')
                    ->whereIn(
                        'id_produto',
                        $produtos
                    )
                    ->delete();

                /*
                As imagens são apagadas automaticamente pela
                FK com ON DELETE CASCADE quando o produto é
                excluído.
                */

                DB::table('tb_produto')
                    ->where(
                        'id_usuario',
                        $id
                    )
                    ->delete();
            }

            // Tokens do Sanctum pertencentes ao usuário
            DB::table('personal_access_tokens')
                ->where(
                    'tokenable_id',
                    $id
                )
                ->delete();

            // Finalmente exclui o usuário
            DB::table('tb_usuario')
                ->where(
                    'id_usuario',
                    $id
                )
                ->delete();

            DB::commit();

            return response()->json([

                'message' =>
                    'Usuário excluído com sucesso!'

            ], 200);

        } catch (\Throwable $erro) {

            DB::rollBack();

            return response()->json([

                'message' =>
                    'Não foi possível excluir o usuário.',

                'erro' =>
                    $erro->getMessage()

            ], 500);
        }
    }


    // ============================================================
    // UC44 - GERENCIAR ANÚNCIOS PUBLICADOS
    // ============================================================


    // ------------------------------------------------------------
    // LISTAR ANÚNCIOS
    // ------------------------------------------------------------

    public function listarProdutosAdmin()
    {
        $produtos = DB::table('tb_produto')
            ->join(
                'tb_usuario',
                'tb_produto.id_usuario',
                '=',
                'tb_usuario.id_usuario'
            )
            ->select(
                'tb_produto.*',
                'tb_usuario.nm_usuario as dono_anuncio'
            )
            ->where(
                'tb_produto.st_status',
                '!=',
                'E'
            )
            ->get();

        $produtosComImagens = $produtos->map(
            function ($produto) {

                $imagem = DB::table('tb_imagem_produto')
                    ->where(
                        'id_produto',
                        $produto->id_produto
                    )
                    ->orderBy(
                        'nr_ordem',
                        'asc'
                    )
                    ->first();

                $produto->ds_imagem =
                    $imagem
                        ? $imagem->ds_imagem
                        : null;

                return $produto;
            }
        );

        return response()->json(
            $produtosComImagens,
            200
        );
    }


    // ------------------------------------------------------------
    // VISUALIZAR DETALHES DO ANÚNCIO
    // UC44
    // ------------------------------------------------------------

    public function visualizarProdutoAdmin($id)
    {
        $produto = DB::table('tb_produto')
            ->join(
                'tb_usuario',
                'tb_produto.id_usuario',
                '=',
                'tb_usuario.id_usuario'
            )
            ->leftJoin(
                'tb_categoria',
                'tb_produto.id_categoria',
                '=',
                'tb_categoria.id_categoria'
            )
            ->select(
                'tb_produto.*',
                'tb_usuario.nm_usuario as dono_anuncio',
                'tb_usuario.email as email_usuario',
                'tb_categoria.nm_categoria as nome_categoria'
            )
            ->where(
                'tb_produto.id_produto',
                $id
            )
            ->where(
                'tb_produto.st_status',
                '!=',
                'E'
            )
            ->first();

        if (!$produto) {

            return response()->json([
                'message' =>
                    'Anúncio não encontrado.'
            ], 404);
        }

        $imagens = DB::table('tb_imagem_produto')
            ->where(
                'id_produto',
                $id
            )
            ->orderBy(
                'nr_ordem',
                'asc'
            )
            ->get();

        $produto->imagens = $imagens;

        return response()->json(
            $produto,
            200
        );
    }


    // ------------------------------------------------------------
    // ALTERAR STATUS DO ANÚNCIO
    // ------------------------------------------------------------
    // A = Disponível
    // N = Em negociação
    // T = Trocado
    // S = Suspenso
    // E = Excluído
    // ------------------------------------------------------------

    public function alterarStatusProdutoAdmin($id)
    {
        $produto = DB::table('tb_produto')
            ->where(
                'id_produto',
                $id
            )
            ->where(
                'st_status',
                '!=',
                'E'
            )
            ->first();

        if (!$produto) {

            return response()->json([
                'message' =>
                    'Anúncio não encontrado.'
            ], 404);
        }

        if ($produto->st_status === 'S') {

            $novoStatus = 'A';

        } else {

            $novoStatus = 'S';

        }

        DB::table('tb_produto')
            ->where(
                'id_produto',
                $id
            )
            ->update([

                'st_status' =>
                    $novoStatus,

                'updated_at' =>
                    now()

            ]);

        $mensagem =
            $novoStatus === 'S'
                ? 'Anúncio suspenso com sucesso!'
                : 'Anúncio disponibilizado novamente!';

        return response()->json([

            'message' =>
                $mensagem,

            'st_status' =>
                $novoStatus

        ], 200);
    }


    // ------------------------------------------------------------
    // SUSPENDER ANÚNCIO
    // ------------------------------------------------------------

    public function suspenderProdutoAdmin($id)
    {
        $produto = DB::table('tb_produto')
            ->where(
                'id_produto',
                $id
            )
            ->where(
                'st_status',
                '!=',
                'E'
            )
            ->first();

        if (!$produto) {

            return response()->json([
                'message' =>
                    'Anúncio não encontrado.'
            ], 404);
        }

        DB::table('tb_produto')
            ->where(
                'id_produto',
                $id
            )
            ->update([

                'st_status' =>
                    'S',

                'updated_at' =>
                    now()

            ]);

        return response()->json([

            'message' =>
                'Anúncio suspenso com sucesso!'

        ], 200);
    }


    // ------------------------------------------------------------
    // EXCLUIR ANÚNCIO
    // EXCLUSÃO LÓGICA
    // ------------------------------------------------------------

    public function excluirProdutoAdmin($id)
    {
        $produto = DB::table('tb_produto')
            ->where(
                'id_produto',
                $id
            )
            ->where(
                'st_status',
                '!=',
                'E'
            )
            ->first();

        if (!$produto) {

            return response()->json([
                'message' =>
                    'Anúncio não encontrado.'
            ], 404);
        }

        DB::table('tb_produto')
            ->where(
                'id_produto',
                $id
            )
            ->update([

                'st_status' =>
                    'E',

                'updated_at' =>
                    now()

            ]);

        return response()->json([

            'message' =>
                'Anúncio excluído com sucesso!'

        ], 200);
    }
}
