<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class DenunciaController extends Controller
{
    public function store(Request $request)
    {
        $usuario = $request->user();

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não autenticado.',
            ], 401);
        }

        if ($usuario->st_usuario === 'B') {
            return response()->json([
                'message' => 'Sua conta está bloqueada.',
            ], 403);
        }

        foreach (['categoria', 'descricao'] as $campo) {
            if (is_string($request->input($campo))) {
                $request->merge([
                    $campo => trim($request->input($campo)),
                ]);
            }
        }

        $categorias = [
            'Comportamento ofensivo',
            'Assédio',
            'Golpe ou fraude',
            'Conteúdo impróprio',
            'Spam',
            'Problema durante a negociação',
            'Outro',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'id_usuario_denunciado' => [
                    'bail',
                    'required',
                    'integer',
                    'exists:tb_usuario,id_usuario',
                ],

                'categoria' => [
                    'required',
                    'string',
                    Rule::in($categorias),
                ],

                'descricao' => [
                    'required',
                    'string',
                    'min:10',
                    'max:500',
                ],

                'imagens' => [
                    'sometimes',
                    'array',
                    'max:3',
                ],

                'imagens.*' => [
                    'required',
                    'file',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
            ],
            [
                'id_usuario_denunciado.required' =>
                    'Informe o usuário denunciado.',

                'id_usuario_denunciado.integer' =>
                    'O usuário denunciado é inválido.',

                'id_usuario_denunciado.exists' =>
                    'O usuário denunciado não foi encontrado.',

                'categoria.required' =>
                    'Selecione o motivo da denúncia.',

                'categoria.string' =>
                    'O motivo da denúncia é inválido.',

                'categoria.in' =>
                    'Selecione um motivo válido.',

                'descricao.required' =>
                    'Descreva o que aconteceu.',

                'descricao.string' =>
                    'A descrição deve ser um texto.',

                'descricao.min' =>
                    'A descrição deve possuir pelo menos 10 caracteres.',

                'descricao.max' =>
                    'A descrição deve possuir no máximo 500 caracteres.',

                'imagens.array' =>
                    'As imagens devem ser enviadas como uma lista.',

                'imagens.max' =>
                    'Você pode enviar no máximo 3 imagens.',

                'imagens.*.required' =>
                    'Uma das imagens está vazia.',

                'imagens.*.file' =>
                    'Um dos arquivos enviados é inválido.',

                'imagens.*.uploaded' =>
                    'Não foi possível receber uma das imagens. Confira seu tamanho.',

                'imagens.*.image' =>
                    'Os arquivos enviados devem ser imagens.',

                'imagens.*.mimes' =>
                    'Envie imagens nos formatos JPG, PNG ou WEBP.',

                'imagens.*.max' =>
                    'Cada imagem deve possuir no máximo 5 MB.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $dados = $validator->validated();

        if (
            (int) $usuario->id_usuario ===
            (int) $dados['id_usuario_denunciado']
        ) {
            return response()->json([
                'message' => 'Você não pode denunciar sua própria conta.',
            ], 422);
        }

        $arquivosSalvos = [];

        try {
            $denuncia = DB::transaction(function () use (
                $request,
                $usuario,
                $dados,
                &$arquivosSalvos
            ) {
                $denuncia = Denuncia::create([
                    // Obtido do token, nunca do formulário.
                    'id_usuario' => $usuario->id_usuario,

                    'id_usuario_denunciado' =>
                        $dados['id_usuario_denunciado'],

                    'id_produto' => null,
                    'ds_motivo' => $dados['categoria'],
                    'ds_denuncia' => $dados['descricao'],

                    // P = Pendente.
                    'st_denuncia' => 'P',
                ]);

                foreach (
                    $request->file('imagens', []) as $indice => $imagem
                ) {
                    $caminho = $imagem->store(
                        (string) $denuncia->id_denuncia,
                        'denuncias'
                    );

                    if (!$caminho) {
                        throw new \RuntimeException(
                            'Não foi possível salvar a evidência.'
                        );
                    }

                    $arquivosSalvos[] = $caminho;

                    DB::table('tb_imagem_denuncia')->insert([
                        'id_denuncia' => $denuncia->id_denuncia,
                        'ds_imagem' => $caminho,
                        'nr_ordem' => $indice + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                return $denuncia;
            });
        } catch (Throwable $erro) {
            // A transação desfaz os registros.
            // Aqui removemos os arquivos já gravados.
            if ($arquivosSalvos !== []) {
                try {
                    Storage::disk('denuncias')->delete($arquivosSalvos);
                } catch (Throwable $erroLimpeza) {
                    report($erroLimpeza);
                }
            }

            report($erro);

            return response()->json([
                'message' =>
                    'Não foi possível registrar a denúncia. Tente novamente.',
            ], 500);
        }

        return response()->json([
            'message' => 'Denúncia registrada com sucesso.',
            'denuncia' => [
                'id_denuncia' => $denuncia->id_denuncia,
                'st_denuncia' => $denuncia->st_denuncia,
                'quantidade_imagens' => count($arquivosSalvos),
            ],
        ], 201);
    }
}