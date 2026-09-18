<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ImagemProduto;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ============================================================
    // LISTAR TODOS OS PRODUTOS
    // HOME + PESQUISA + FILTROS
    // ============================================================

    public function index(Request $request)
    {
        $query = Product::with([
            'user',
            'images',
            'categoria'
        ])->where('st_status', 'A');

        // --------------------------------------------------------
        // PESQUISA POR TEXTO
        // --------------------------------------------------------

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where(
                    'nm_produto',
                    'LIKE',
                    "%{$search}%"
                )
                ->orWhere(
                    'ds_produto',
                    'LIKE',
                    "%{$search}%"
                );
            });
        }

        // --------------------------------------------------------
        // FILTRO POR CATEGORIA
        // --------------------------------------------------------

        if ($request->filled('category')) {
            $query->where(
                'id_categoria',
                $request->category
            );
        }

        // --------------------------------------------------------
        // FILTRO POR CONDIÇÃO
        // --------------------------------------------------------

        if ($request->filled('condition')) {
            $query->where(
                'st_condicao',
                $request->condition
            );
        }

        // --------------------------------------------------------
        // BUSCA
        // --------------------------------------------------------

        $products = $query
            ->latest()
            ->get();

        return response()->json(
            $products,
            200
        );
    }


    // ============================================================
    // VISUALIZAR UM PRODUTO ESPECÍFICO
    // ============================================================

    public function show($id)
    {
        $product = Product::with([
            'user',
            'images',
            'categoria'
        ])
            ->where(
                'id_produto',
                $id
            )
            ->where(
                'st_status',
                'A'
            )
            ->first();

        if (!$product) {
            return response()->json([
                'message' =>
                    'Produto não encontrado.'
            ], 404);
        }

        return response()->json(
            $product,
            200
        );
    }


    // ============================================================
    // CADASTRAR PRODUTO
    // COM UPLOAD DE IMAGEM
    // ============================================================

    public function store(Request $request)
    {
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
                'required|string|max:1',

            'imagem' =>
                'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // --------------------------------------------------------
        // USUÁRIO AUTENTICADO
        // --------------------------------------------------------

        $validatedData['id_usuario'] =
            $request->user()->id_usuario;

        // --------------------------------------------------------
        // SALVAR PRODUTO
        // --------------------------------------------------------

        $produto =
            Product::create(
                $validatedData
            );

        // --------------------------------------------------------
        // SALVAR IMAGEM
        // --------------------------------------------------------

        if ($request->hasFile('imagem')) {

            $caminhoImagem =
                $request
                    ->file('imagem')
                    ->store(
                        'products',
                        'public'
                    );

            ImagemProduto::create([
                'id_produto' =>
                    $produto->id_produto,

                'ds_imagem' =>
                    $caminhoImagem,

                'nr_ordem' =>
                    1
            ]);
        }

        // --------------------------------------------------------
        // CARREGAR RELACIONAMENTOS
        // --------------------------------------------------------

        $produto->load([
            'user',
            'images',
            'categoria'
        ]);

        // --------------------------------------------------------
        // RESPOSTA
        // --------------------------------------------------------

        return response()->json([
            'message' =>
                'Produto cadastrado com sucesso!',

            'product' =>
                $produto
        ], 201);
    }


    // ============================================================
    // LISTAR PRODUTOS DO USUÁRIO LOGADO
    //
    // SEM STATUS:
    // A = Disponível
    // N = Em negociação
    //
    // status=T:
    // T = Trocado
    // ============================================================


// ============================================================
// LISTAR PRODUTOS DE UM USUÁRIO ESPECÍFICO
// VISUALIZAR PERFIL DE OUTRO USUÁRIO
//
// A = Disponível
// N = Em negociação
// T = Trocado
// E = Excluído -> não aparece
// ============================================================

public function productsByUser($id)
{
    // --------------------------------------------------------
    // VERIFICAR SE O USUÁRIO EXISTE
    // --------------------------------------------------------

    $usuario = \App\Models\User::find($id);

    if (!$usuario) {
        return response()->json([
            'message' => 'Usuário não encontrado.'
        ], 404);
    }

    // --------------------------------------------------------
    // BUSCAR PRODUTOS DO USUÁRIO
    // --------------------------------------------------------

    $products = Product::with([
        'user',
        'images',
        'categoria'
    ])
        ->where('id_usuario', $id)
        ->whereIn('st_status', ['A', 'N', 'T'])
        ->latest()
        ->get();

    // --------------------------------------------------------
    // RETORNO
    // --------------------------------------------------------

    return response()->json(
        $products,
        200
    );
}



    public function myProducts(Request $request)
    {
        $userId =
            $request->user()->id_usuario;

        $query = Product::with([
            'user',
            'images',
            'categoria'
        ])
            ->where(
                'id_usuario',
                $userId
            );

        // --------------------------------------------------------
        // FILTRO DE STATUS
        // --------------------------------------------------------

        if ($request->filled('status')) {

            $status = strtoupper(
                $request->status
            );

            if (!in_array($status, ['A', 'N', 'T'])) {
                return response()->json([
                    'message' =>
                        'Status inválido.'
                ], 422);
            }

            $query->where(
                'st_status',
                $status
            );

        } else {

            // ----------------------------------------------------
            // ANÚNCIOS NORMAIS
            // A = Disponível
            // N = Em negociação
            //
            // Os trocados NÃO aparecem aqui.
            // ----------------------------------------------------

            $query->whereIn(
                'st_status',
                ['A', 'N']
            );
        }

        // --------------------------------------------------------
        // BUSCAR PRODUTOS
        // --------------------------------------------------------

        $products = $query
            ->latest()
            ->get();

        // --------------------------------------------------------
        // RESPOSTA
        // --------------------------------------------------------

        return response()->json(
            $products,
            200
        );
    }


    // ============================================================
    // UC18 - INFORMAR STATUS DO ITEM
    //
    // A = Disponível
    // N = Em negociação
    // T = Trocado
    // ============================================================

    public function updateStatus(
        Request $request,
        $id
    ) {
        $validatedData =
            $request->validate(
                [
                    'st_status' =>
                        'required|in:A,N,T',
                ],
                [
                    'st_status.required' =>
                        'Selecione o status de disponibilidade do item.',

                    'st_status.in' =>
                        'Selecione um status de disponibilidade válido.',
                ]
            );

        // --------------------------------------------------------
        // USUÁRIO AUTENTICADO
        // --------------------------------------------------------

        $usuario =
            $request->user();

        // --------------------------------------------------------
        // BUSCAR PRODUTO
        // --------------------------------------------------------

        $produto =
            Product::find($id);

        if (!$produto) {
            return response()->json([
                'message' =>
                    'Produto não encontrado.'
            ], 404);
        }

        // --------------------------------------------------------
        // VERIFICAR DONO
        // --------------------------------------------------------

        if (
            $produto->id_usuario !==
            $usuario->id_usuario
        ) {
            return response()->json([
                'message' =>
                    'Você não pode alterar o status deste produto.'
            ], 403);
        }

        // --------------------------------------------------------
        // ATUALIZAR PRODUTO
        // --------------------------------------------------------

        $produto->update([
            'st_status' =>
                $validatedData['st_status']
        ]);

        // --------------------------------------------------------
        // CARREGAR RELACIONAMENTOS
        // --------------------------------------------------------

        $produto->load([
            'user',
            'images',
            'categoria'
        ]);

        // --------------------------------------------------------
        // RESPOSTA
        // --------------------------------------------------------

        return response()->json([
            'message' =>
                'Status do produto atualizado com sucesso!',

            'product' =>
                $produto
        ], 200);
    }


    // ============================================================
    // UC14 - EDITAR ANÚNCIO
    // ============================================================

    public function update(
        Request $request,
        $id
    ) {
        // --------------------------------------------------------
        // VALIDAÇÃO
        // --------------------------------------------------------

        $validatedData =
            $request->validate(
                [
                    'id_categoria' =>
                        'required|integer|exists:tb_categoria,id_categoria',

                    'nm_produto' =>
                        'required|string|max:100',

                    'ds_produto' =>
                        'nullable|string|max:255',

                    'st_condicao' =>
                        'required|string|max:1',

                    'st_status' =>
                        'required|string|max:1',
                ],
                [
                    'id_categoria.required' =>
                        'A categoria é obrigatória.',

                    'id_categoria.exists' =>
                        'A categoria selecionada não existe.',

                    'nm_produto.required' =>
                        'O nome do produto é obrigatório.',

                    'nm_produto.max' =>
                        'O nome do produto deve ter no máximo 100 caracteres.',

                    'ds_produto.max' =>
                        'A descrição deve ter no máximo 255 caracteres.',

                    'st_condicao.required' =>
                        'O estado de conservação é obrigatório.',

                    'st_status.required' =>
                        'O status do produto é obrigatório.',
                ]
            );

        // --------------------------------------------------------
        // USUÁRIO AUTENTICADO
        // --------------------------------------------------------

        $usuario =
            $request->user();

        // --------------------------------------------------------
        // BUSCAR PRODUTO
        // --------------------------------------------------------

        $produto =
            Product::find($id);

        if (!$produto) {
            return response()->json([
                'message' =>
                    'Produto não encontrado.'
            ], 404);
        }

        // --------------------------------------------------------
        // VERIFICAR DONO
        // --------------------------------------------------------

        if (
            $produto->id_usuario !==
            $usuario->id_usuario
        ) {
            return response()->json([
                'message' =>
                    'Você não pode editar este produto.'
            ], 403);
        }

        // --------------------------------------------------------
        // ATUALIZAR PRODUTO
        // --------------------------------------------------------

        $produto->update([
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
        ]);

        // --------------------------------------------------------
        // CARREGAR RELACIONAMENTOS
        // --------------------------------------------------------

        $produto->load([
            'user',
            'images',
            'categoria'
        ]);

        // --------------------------------------------------------
        // RESPOSTA
        // --------------------------------------------------------

        return response()->json([
            'message' =>
                'Produto atualizado com sucesso!',

            'product' =>
                $produto
        ], 200);
    }


    // ============================================================
    // UC14 - EXCLUIR ANÚNCIO
    // EXCLUSÃO LÓGICA
    // ============================================================

    public function destroy(
        Request $request,
        $id
    ) {
        // --------------------------------------------------------
        // USUÁRIO AUTENTICADO
        // --------------------------------------------------------

        $usuario =
            $request->user();

        // --------------------------------------------------------
        // BUSCAR PRODUTO
        // --------------------------------------------------------

        $produto =
            Product::find($id);

        if (!$produto) {
            return response()->json([
                'message' =>
                    'Produto não encontrado.'
            ], 404);
        }

        // --------------------------------------------------------
        // VERIFICAR DONO
        // --------------------------------------------------------

        if (
            $produto->id_usuario !==
            $usuario->id_usuario
        ) {
            return response()->json([
                'message' =>
                    'Você não pode excluir este produto.'
            ], 403);
        }

        // --------------------------------------------------------
        // EXCLUSÃO LÓGICA
        // --------------------------------------------------------

        $produto->update([
            'st_status' => 'E'
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