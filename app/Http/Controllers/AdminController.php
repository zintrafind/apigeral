<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ============================================================
    // UC52 - GERENCIAR USUÁRIOS
    // ============================================================

    public function listarUsuarios()
    {
        $usuarios = DB::table('tb_usuario')
            ->select(
                'id_usuario',
                'nm_usuario',
                'email',
                'tp_usuario',
                'st_usuario',
                'created_at'
            )
            ->get();

        return response()->json($usuarios);
    }


    public function excluirUsuario($id)
    {
        $deletou = DB::table('tb_usuario')
            ->where('id_usuario', $id)
            ->delete();

        if (!$deletou) {
            return response()->json([
                'message' => 'Utilizador não encontrado.'
            ], 404);
        }

        return response()->json([
            'message' => 'Utilizador excluído com sucesso.'
        ], 200);
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

            // Não exibir anúncios excluídos logicamente
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
        // --------------------------------------------------------
        // BUSCAR ANÚNCIO
        // JUNTO COM USUÁRIO E CATEGORIA
        // --------------------------------------------------------

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


        // --------------------------------------------------------
        // VERIFICAR SE O ANÚNCIO EXISTE
        // --------------------------------------------------------

        if (!$produto) {

            return response()->json([
                'message' =>
                    'Anúncio não encontrado.'
            ], 404);
        }


        // --------------------------------------------------------
        // BUSCAR IMAGENS DO ANÚNCIO
        // --------------------------------------------------------

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


        // --------------------------------------------------------
        // ADICIONAR IMAGENS AO RETORNO
        // --------------------------------------------------------

        $produto->imagens = $imagens;


        // --------------------------------------------------------
        // RETORNAR DETALHES
        // --------------------------------------------------------

        return response()->json(
            $produto,
            200
        );
    }


    // ------------------------------------------------------------
    // EDITAR ANÚNCIO
    // ------------------------------------------------------------

    public function editarProdutoAdmin(
        Request $request,
        $id
    ) {

        // --------------------------------------------------------
        // VALIDAÇÃO
        // --------------------------------------------------------

        $validatedData = $request->validate([

            'id_categoria' =>
                'required|integer|exists:tb_categoria,id_categoria',

            'nm_produto' =>
                'required|string|max:100',

            'ds_produto' =>
                'nullable|string|max:255',

            'st_condicao' =>
                'required|string|max:1',

            'st_status' =>
                'required|in:A,N,T,S'

        ]);


        // --------------------------------------------------------
        // BUSCAR ANÚNCIO
        // --------------------------------------------------------

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


        // --------------------------------------------------------
        // ATUALIZAR ANÚNCIO
        // --------------------------------------------------------

        DB::table('tb_produto')
            ->where(
                'id_produto',
                $id
            )
            ->update([

                'id_categoria' =>
                    $validatedData['id_categoria'],

                'nm_produto' =>
                    $validatedData['nm_produto'],

                'ds_produto' =>
                    $validatedData['ds_produto'] ?? null,

                'st_condicao' =>
                    $validatedData['st_condicao'],

                'st_status' =>
                    $validatedData['st_status'],

                'updated_at' =>
                    now()

            ]);


        // --------------------------------------------------------
        // BUSCAR ANÚNCIO ATUALIZADO
        // --------------------------------------------------------

        $produtoAtualizado = DB::table('tb_produto')
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
                'tb_categoria.nm_categoria as nome_categoria'
            )
            ->where(
                'tb_produto.id_produto',
                $id
            )
            ->first();


        // --------------------------------------------------------
        // RESPOSTA
        // --------------------------------------------------------

        return response()->json([

            'message' =>
                'Anúncio atualizado com sucesso!',

            'product' =>
                $produtoAtualizado

        ], 200);
    }


    // ------------------------------------------------------------
    // SUSPENDER ANÚNCIO
    // ------------------------------------------------------------

    public function suspenderProdutoAdmin($id)
    {
        // --------------------------------------------------------
        // BUSCAR ANÚNCIO
        // --------------------------------------------------------

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


        // --------------------------------------------------------
        // SUSPENDER
        // S = SUSPENSO
        // --------------------------------------------------------

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


        // --------------------------------------------------------
        // RESPOSTA
        // --------------------------------------------------------

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
        // --------------------------------------------------------
        // BUSCAR ANÚNCIO
        // --------------------------------------------------------

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


        // --------------------------------------------------------
        // EXCLUSÃO LÓGICA
        // E = EXCLUÍDO
        // --------------------------------------------------------

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


        // --------------------------------------------------------
        // RESPOSTA
        // --------------------------------------------------------

        return response()->json([

            'message' =>
                'Anúncio excluído com sucesso!'

        ], 200);
    }
}
