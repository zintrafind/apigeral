<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // --- UC52: GERENCIAR UTILIZADORES ---

    public function listarUsuarios()
    {
        $usuarios = DB::table('tb_usuario')->select('id_usuario', 'nm_usuario', 'email', 'tp_usuario', 'st_usuario', 'created_at')->get();
        return response()->json($usuarios);
    }

    public function excluirUsuario($id)
    {
        $deletou = DB::table('tb_usuario')->where('id_usuario', $id)->delete();

        if (!$deletou) {
            return response()->json(['message' => 'Utilizador não encontrado.'], 404);
        }

        return response()->json(['message' => 'Utilizador excluído com sucesso.']);
    }

    // --- UC53: GERENCIAR ANÚNCIOS ---

    public function listarProdutosAdmin()
    {
        $produtos = DB::table('tb_produto')
            ->join('tb_usuario', 'tb_produto.id_usuario', '=', 'tb_usuario.id_usuario')
            ->select('tb_produto.*', 'tb_usuario.nm_usuario as dono_anuncio')
            ->get();

        $produtosComImagens = $produtos->map(function ($produto) {
            $imagem = DB::table('tb_imagem_produto')
                ->where('id_produto', $produto->id_produto)
                ->orderBy('nr_ordem', 'asc')
                ->first();

            $produto->ds_imagem = $imagem ? $imagem->ds_imagem : null;

            return $produto;
        });

        return response()->json($produtosComImagens);
    }

    public function excluirProdutoAdmin($id)
    {
        $deletou = DB::table('tb_produto')->where('id_produto', $id)->delete();

        if (!$deletou) {
            return response()->json(['message' => 'Anúncio não encontrado.'], 404);
        }

        return response()->json(['message' => 'Anúncio excluído com sucesso.']);
    }
}
