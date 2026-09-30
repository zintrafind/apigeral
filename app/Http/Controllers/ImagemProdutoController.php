<?php

namespace App\Http\Controllers;

use App\Models\ImagemProduto;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ImagemProdutoController extends Controller
{
    /**
     * Adiciona uma imagem individual ao produto.
     *
     * Aceita:
     * POST /produtos/imagem, com id_produto no corpo.
     * POST /produtos/{id}/imagem, com ID na rota.
     */
    public function store(Request $request, $id = null)
    {
        $usuario = $request->user();

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não autenticado.',
            ], 401);
        }

        if ($id !== null) {
            $request->merge([
                'id_produto' => $id,
            ]);
        }

        $dados = $request->validate([
            'id_produto' =>
                'required|integer|exists:tb_produto,id_produto',

            'imagem' =>
                'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], $this->mensagensValidacao());

        $caminhoNovo = null;

        try {
            $imagem = DB::transaction(function () use (
                $request,
                $dados,
                $usuario,
                &$caminhoNovo
            ) {
                // Todos os uploads bloqueiam primeiro o produto.
                $produto = Product::where(
                    'id_produto',
                    $dados['id_produto']
                )
                    ->lockForUpdate()
                    ->first();

                if (!$produto) {
                    abort(404, 'Produto não encontrado.');
                }

                $this->verificarPermissao($produto, $usuario);

                $imagens = ImagemProduto::where(
                    'id_produto',
                    $produto->id_produto
                )
                    ->lockForUpdate()
                    ->get();

                if ($imagens->count() >= 5) {
                    throw ValidationException::withMessages([
                        'imagem' =>
                            'Este anúncio já possui cinco imagens.',
                    ]);
                }

                $caminhoNovo = $request
                    ->file('imagem')
                    ->store('products', 'public');

                if (!$caminhoNovo) {
                    throw new \RuntimeException(
                        'Não foi possível salvar a imagem.'
                    );
                }

                $ultimaOrdem = (int) ($imagens->max('nr_ordem') ?? 0);

                return ImagemProduto::create([
                    'id_produto' => $produto->id_produto,
                    'ds_imagem' => $caminhoNovo,
                    'nr_ordem' => $ultimaOrdem + 1,
                ]);
            });
        } catch (\Throwable $erro) {
            $this->excluirArquivo($caminhoNovo);

            throw $erro;
        }

        return response()->json([
            'message' => 'Imagem cadastrada com sucesso!',
            'imagem' => $imagem,
        ], 201);
    }

    /**
     * Substitui uma imagem.
     *
     * $id é o ID da imagem, não o ID do produto.
     */
    public function update(Request $request, $id)
    {
        $usuario = $request->user();

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não autenticado.',
            ], 401);
        }

        $request->validate([
            'imagem' =>
                'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], $this->mensagensValidacao());

        $referencia = ImagemProduto::find($id);

        if (!$referencia) {
            return response()->json([
                'message' => 'Imagem não encontrada.',
            ], 404);
        }

        $caminhoNovo = null;
        $caminhoAntigo = null;

        try {
            $imagem = DB::transaction(function () use (
                $request,
                $id,
                $referencia,
                $usuario,
                &$caminhoNovo,
                &$caminhoAntigo
            ) {
                $produto = Product::where(
                    'id_produto',
                    $referencia->id_produto
                )
                    ->lockForUpdate()
                    ->first();

                if (!$produto) {
                    abort(404, 'Produto não encontrado.');
                }

                $this->verificarPermissao($produto, $usuario);

                $imagem = ImagemProduto::where('id_imagem', $id)
                    ->where('id_produto', $produto->id_produto)
                    ->lockForUpdate()
                    ->first();

                if (!$imagem) {
                    abort(404, 'Imagem não encontrada.');
                }

                $caminhoAntigo = $imagem->ds_imagem;

                // Salva o novo arquivo antes de excluir o antigo.
                $caminhoNovo = $request
                    ->file('imagem')
                    ->store('products', 'public');

                if (!$caminhoNovo) {
                    throw new \RuntimeException(
                        'Não foi possível salvar a nova imagem.'
                    );
                }

                $imagem->update([
                    'ds_imagem' => $caminhoNovo,
                ]);

                return $imagem;
            });
        } catch (\Throwable $erro) {
            $this->excluirArquivo($caminhoNovo);

            throw $erro;
        }

        $this->excluirArquivo($caminhoAntigo);

        return response()->json([
            'message' => 'Imagem atualizada com sucesso!',
            'imagem' => $imagem,
        ], 200);
    }

    /**
     * Remove uma imagem individual e reorganiza a ordem.
     * Mantém pelo menos uma foto no anúncio.
     */
    public function destroy(Request $request, $id)
    {
        $usuario = $request->user();

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não autenticado.',
            ], 401);
        }

        $referencia = ImagemProduto::find($id);

        if (!$referencia) {
            return response()->json([
                'message' => 'Imagem não encontrada.',
            ], 404);
        }

        $caminhoAntigo = null;

        DB::transaction(function () use (
            $id,
            $referencia,
            $usuario,
            &$caminhoAntigo
        ) {
            $produto = Product::where(
                'id_produto',
                $referencia->id_produto
            )
                ->lockForUpdate()
                ->first();

            if (!$produto) {
                abort(404, 'Produto não encontrado.');
            }

            $this->verificarPermissao($produto, $usuario);

            $imagens = ImagemProduto::where(
                'id_produto',
                $produto->id_produto
            )
                ->orderBy('nr_ordem')
                ->orderBy('id_imagem')
                ->lockForUpdate()
                ->get();

            $imagem = $imagens->first(function ($item) use ($id) {
                return (string) $item->id_imagem === (string) $id;
            });

            if (!$imagem) {
                abort(404, 'Imagem não encontrada.');
            }

            if ($imagens->count() <= 1) {
                throw ValidationException::withMessages([
                    'imagem' =>
                        'O anúncio precisa ter pelo menos uma imagem.',
                ]);
            }

            $caminhoAntigo = $imagem->ds_imagem;

            $imagem->delete();

            $ordem = 1;

            foreach ($imagens as $item) {
                if ((string) $item->id_imagem === (string) $id) {
                    continue;
                }

                $item->update([
                    'nr_ordem' => $ordem,
                ]);

                $ordem++;
            }
        });

        $this->excluirArquivo($caminhoAntigo);

        return response()->json([
            'message' => 'Imagem removida com sucesso!',
        ], 200);
    }

    private function verificarPermissao(
        Product $produto,
        $usuario
    ): void {
        if (
            (string) $produto->id_usuario !==
            (string) $usuario->getAuthIdentifier()
        ) {
            abort(
                403,
                'Você não pode alterar as imagens deste produto.'
            );
        }

        if (in_array($produto->st_status, ['T', 'E'], true)) {
            throw ValidationException::withMessages([
                'produto' =>
                    'Não é possível alterar fotos de um anúncio trocado ou excluído.',
            ]);
        }
    }

    private function excluirArquivo(?string $caminho): void
    {
        if (!$caminho) {
            return;
        }

        $caminho = preg_replace(
            '#^/?storage/#',
            '',
            $caminho
        );

        $caminho = ltrim($caminho, '/');

        try {
            if (!Storage::disk('public')->delete($caminho)) {
                report(new \RuntimeException(
                    'Não foi possível excluir o arquivo: ' . $caminho
                ));
            }
        } catch (\Throwable $erro) {
            report($erro);
        }
    }

    private function mensagensValidacao(): array
    {
        return [
            'id_produto.required' =>
                'Informe o produto.',

            'id_produto.integer' =>
                'O ID do produto é inválido.',

            'id_produto.exists' =>
                'Produto não encontrado.',

            'imagem.required' =>
                'Selecione uma imagem.',

            'imagem.image' =>
                'O arquivo precisa ser uma imagem válida.',

            'imagem.mimes' =>
                'Use uma imagem JPG, JPEG, PNG, GIF ou WEBP.',

            'imagem.max' =>
                'A imagem deve ter no máximo 5 MB.',
        ];
    }
}