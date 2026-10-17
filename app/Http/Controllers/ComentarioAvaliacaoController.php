<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\ComentarioAvaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComentarioAvaliacaoController extends Controller
{
    private const TERMOS_BLOQUEADOS = [
        'idiota',
        'burro',
        'imbecil',
        'otario',
        'filho da puta',
        'filha da puta',
        'puta',
        'desgracado',
        'desgracada',
        'arrombado',
        'arrombada',
        'babaca',
        'lixo',
        'merda',
        'fdp',
        'vai tomar no cu',
        'vai se foder',
        'foda se',
        'fodido',
        'fodida',
        'vagabundo',
        'vagabunda',
        'cretino',
        'cretina',
    ];

    public function index(int $id)
    {
        $avaliacao = Avaliacao::find($id);

        if (!$avaliacao) {
            return response()->json([
                'message' => 'Avaliação não encontrada.',
            ], 404);
        }

        $comentarios = ComentarioAvaliacao::query()
            ->where('id_avaliacao', $avaliacao->id_avaliacao)
            ->select([
                'id_comentario',
                'id_avaliacao',
                'id_usuario',
                'ds_comentario',
                'created_at',
            ])
            ->with('autor:id_usuario,nm_usuario,ds_foto_perfil')
            ->orderBy('created_at')
            ->orderBy('id_comentario')
            ->get();

        return response()->json([
            'comentarios' => $comentarios,
        ], 200);
    }

    public function store(Request $request, int $id)
    {
        $avaliacao = Avaliacao::find($id);

        if (!$avaliacao) {
            return response()->json([
                'message' => 'Avaliação não encontrada.',
            ], 404);
        }

        $comentarioNormalizado = trim((string) $request->input('ds_comentario', ''));
        $request->merge(['ds_comentario' => $comentarioNormalizado]);

        $validatedData = $request->validate([
            'ds_comentario' => ['required', 'string', 'max:500'],
        ]);

        $textoNormalizado = Str::ascii(Str::lower($validatedData['ds_comentario']));
        $textoNormalizado = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $textoNormalizado) ?? $textoNormalizado;
        $termos = array_map(function (string $termo): string {
            $palavras = preg_split('/\s+/', $termo, -1, PREG_SPLIT_NO_EMPTY) ?: [];

            return implode('\s+', array_map('preg_quote', $palavras));
        }, self::TERMOS_BLOQUEADOS);
        $padrao = '/(?<![\p{L}\p{N}_])(?:' . implode('|', $termos) . ')(?![\p{L}\p{N}_])/u';

        if (preg_match($padrao, $textoNormalizado) === 1) {
            return response()->json([
                'message' => 'Seu comentário contém conteúdo inadequado e não pode ser publicado.',
            ], 422);
        }

        $comentario = ComentarioAvaliacao::create([
            'id_avaliacao' => $avaliacao->id_avaliacao,
            'id_usuario' => $request->user()->id_usuario,
            'ds_comentario' => $validatedData['ds_comentario'],
        ]);

        $comentario->load('autor:id_usuario,nm_usuario,ds_foto_perfil');

        return response()->json([
            'message' => 'Comentário publicado com sucesso.',
            'comentario' => $comentario,
        ], 201);
    }
}
