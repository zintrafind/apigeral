<?php

namespace App\Http\Controllers;

use App\Models\ImagemProduto;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagemProdutoController extends Controller
{
    /**
     * Cadastrar uma imagem para um produto.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_produto' => 'required|integer|exists:tb_produto,id_produto',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $usuario = $request->user();

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não autenticado.'
            ], 401);
        }

        $produto = Product::find($validatedData['id_produto']);

        if (!$produto) {
            return response()->json([
                'message' => 'Produto não encontrado.'
            ], 404);
        }

        // Verifica se o produto pertence ao usuário logado
        if ($produto->id_usuario !== $usuario->id_usuario) {
            return response()->json([
                'message' => 'Você não pode adicionar imagem a este produto.'
            ], 403);
        }

        // Salva a imagem
        $caminhoImagem = $request
            ->file('imagem')
            ->store('products', 'public');

        // Define a próxima ordem
        $ultimaOrdem = ImagemProduto::where(
            'id_produto',
            $produto->id_produto
        )->max('nr_ordem');

        $imagem = ImagemProduto::create([
            'id_produto' => $produto->id_produto,
            'ds_imagem' => $caminhoImagem,
            'nr_ordem' => ($ultimaOrdem ?? 0) + 1,
        ]);

        return response()->json([
            'message' => 'Imagem cadastrada com sucesso!',
            'imagem' => $imagem
        ], 201);
    }

    /**
     * Atualizar uma imagem de produto.
     */
    public function update(
        Request $request,
        $id
    ) {
        $validatedData = $request->validate([
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $usuario = $request->user();

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não autenticado.'
            ], 401);
        }

        $imagem = ImagemProduto::find($id);

        if (!$imagem) {
            return response()->json([
                'message' => 'Imagem não encontrada.'
            ], 404);
        }

        $produto = Product::find($imagem->id_produto);

        if (!$produto) {
            return response()->json([
                'message' => 'Produto não encontrado.'
            ], 404);
        }

        // Verifica se o produto pertence ao usuário logado
        if ($produto->id_usuario !== $usuario->id_usuario) {
            return response()->json([
                'message' => 'Você não pode alterar esta imagem.'
            ], 403);
        }

        // Remove a imagem antiga
        if (
            $imagem->ds_imagem &&
            Storage::disk('public')->exists($imagem->ds_imagem)
        ) {
            Storage::disk('public')->delete(
                $imagem->ds_imagem
            );
        }

        // Salva a nova imagem
        $caminhoImagem = $request
            ->file('imagem')
            ->store('products', 'public');

        $imagem->update([
            'ds_imagem' => $caminhoImagem,
        ]);

        return response()->json([
            'message' => 'Imagem atualizada com sucesso!',
            'imagem' => $imagem
        ], 200);
    }
}
