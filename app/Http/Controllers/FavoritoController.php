<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritoController extends Controller
{
    /**
     * Lista os favoritos do usuário logado.
     */
    public function index(Request $request)
    {
        try {
            $idUsuario = $request->user()->getAuthIdentifier();

            $favoritos = DB::table('tb_favorito')
                ->join(
                    'tb_produto',
                    'tb_favorito.id_produto',
                    '=',
                    'tb_produto.id_produto'
                )
                ->leftJoin(
                    'tb_categoria',
                    'tb_produto.id_categoria',
                    '=',
                    'tb_categoria.id_categoria'
                )
                ->leftJoin(
                    'tb_imagem_produto',
                    function ($join) {
                        $join->on(
                            'tb_produto.id_produto',
                            '=',
                            'tb_imagem_produto.id_produto'
                        )->where(
                            'tb_imagem_produto.nr_ordem',
                            '=',
                            1
                        );
                    }
                )
                ->where(
                    'tb_favorito.id_usuario',
                    $idUsuario
                )
                ->select(
                    // FAVORITO
                    'tb_favorito.id_favorito',
                    'tb_favorito.id_produto',
                    'tb_favorito.created_at as favorito_created_at',

                    // PRODUTO
                    'tb_produto.id_usuario',
                    'tb_produto.id_categoria',
                    'tb_produto.nm_produto',
                    'tb_produto.ds_produto',
                    'tb_produto.st_condicao',
                    'tb_produto.st_status',
                    'tb_produto.created_at',
                    'tb_produto.updated_at',

                    // CATEGORIA
                    'tb_categoria.nm_categoria',

                    // IMAGEM
                    'tb_imagem_produto.id_imagem',
                    'tb_imagem_produto.ds_imagem',
                    'tb_imagem_produto.nr_ordem'
                )
                ->orderByDesc(
                    'tb_favorito.created_at'
                )
                ->get();

            return response()->json(
                $favoritos,
                200
            );

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Erro ao buscar favoritos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Adiciona um produto aos favoritos.
     */
    public function store(Request $request)
    {
        try {
            $dados = $request->validate([
                'id_produto' =>
                    'required|integer'
            ]);

            $idUsuario =
                $request->user()->getAuthIdentifier();

            $idProduto =
                $dados['id_produto'];

            // ====================================================
            // VERIFICAR SE O PRODUTO EXISTE
            // ====================================================

            $produto = DB::table('tb_produto')
                ->where(
                    'id_produto',
                    $idProduto
                )
                ->first();

            if (!$produto) {

                return response()->json([
                    'message' =>
                        'Produto não encontrado.'
                ], 404);
            }

            // ====================================================
            // VERIFICAR SE JÁ ESTÁ FAVORITADO
            // ====================================================

            $favoritoExistente =
                DB::table('tb_favorito')
                    ->where(
                        'id_usuario',
                        $idUsuario
                    )
                    ->where(
                        'id_produto',
                        $idProduto
                    )
                    ->first();

            if ($favoritoExistente) {

                return response()->json([
                    'message' =>
                        'Este item já está nos favoritos.',

                    'id_favorito' =>
                        $favoritoExistente->id_favorito
                ], 200);
            }

            // ====================================================
            // INSERIR FAVORITO
            // ====================================================

            $idFavorito =
                DB::table('tb_favorito')
                    ->insertGetId([
                        'id_usuario' =>
                            $idUsuario,

                        'id_produto' =>
                            $idProduto,

                        'created_at' =>
                            now(),

                        'updated_at' =>
                            null
                    ]);

            return response()->json([
                'message' =>
                    'Item adicionado aos favoritos.',

                'id_favorito' =>
                    $idFavorito,

                'id_produto' =>
                    $idProduto
            ], 201);

        } catch (
            \Illuminate\Validation\ValidationException $e
        ) {

            throw $e;

        } catch (\Exception $e) {

            return response()->json([
                'message' =>
                    'Erro ao adicionar item aos favoritos.',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove um produto dos favoritos.
     */
    public function destroy(
        Request $request,
        $id_produto
    ) {
        try {

            $idUsuario =
                $request->user()->getAuthIdentifier();

            // ====================================================
            // REMOVER FAVORITO
            // ====================================================

            $apagado =
                DB::table('tb_favorito')
                    ->where(
                        'id_usuario',
                        $idUsuario
                    )
                    ->where(
                        'id_produto',
                        $id_produto
                    )
                    ->delete();

            if (!$apagado) {

                return response()->json([
                    'message' =>
                        'Este item não está nos favoritos.'
                ], 404);
            }

            return response()->json([
                'message' =>
                    'Item removido dos favoritos.'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' =>
                    'Erro ao remover item dos favoritos.',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }
}