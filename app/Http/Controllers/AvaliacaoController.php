<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Proposta;
use App\Models\User;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    /**
     * Cria uma avaliação de usuário para uma proposta finalizada.
     */
    public function store(Request $request)
    {
        $request->merge([
            'ds_comentario' => trim((string) $request->input('ds_comentario', '')),
        ]);

        $validatedData = $request->validate([
            'id_proposta' => ['required', 'integer', 'exists:tb_proposta,id_proposta'],
            'nr_nota' => ['required', 'integer', 'min:1', 'max:5'],
            'ds_comentario' => ['required', 'string', 'max:255'],
        ]);

        $usuario = $request->user();
        $proposta = Proposta::find($validatedData['id_proposta']);

        if (!$proposta) {
            return response()->json([
                'message' => 'Proposta não encontrada.',
            ], 404);
        }

        $participaDaProposta = (
            (int) $proposta->id_solicitante === (int) $usuario->id_usuario
            || (int) $proposta->id_destinatario === (int) $usuario->id_usuario
        );

        if (!$participaDaProposta) {
            return response()->json([
                'message' => 'Você não participa desta troca.',
            ], 403);
        }

        if ($proposta->st_troca !== 'F') {
            return response()->json([
                'message' => 'A avaliação só pode ser feita após a troca estar finalizada.',
            ], 422);
        }

        $idAvaliado = (int) $proposta->id_solicitante === (int) $usuario->id_usuario
            ? (int) $proposta->id_destinatario
            : (int) $proposta->id_solicitante;

        $jaAvaliado = Avaliacao::query()
            ->where('id_proposta', $proposta->id_proposta)
            ->where('id_avaliador', $usuario->id_usuario)
            ->exists();

        if ($jaAvaliado) {
            return response()->json([
                'message' => 'Você já avaliou esta troca.',
            ], 422);
        }

        $avaliacao = Avaliacao::create([
            'id_proposta' => $proposta->id_proposta,
            'id_avaliador' => $usuario->id_usuario,
            'id_avaliado' => $idAvaliado,
            'nr_nota' => (int) $validatedData['nr_nota'],
            'ds_comentario' => $validatedData['ds_comentario'] ?? null,
        ]);

        $avaliacao->load([
            'avaliador:id_usuario,nm_usuario,ds_foto_perfil',
            'avaliado:id_usuario,nm_usuario,ds_foto_perfil',
            'proposta:id_proposta,st_troca',
        ]);

        return response()->json([
            'message' => 'Avaliação enviada com sucesso.',
            'avaliacao' => $avaliacao,
        ], 201);
    }

    /**
     * Lista as avaliações recebidas por um usuário.
     */
    public function indexByUsuario(Request $request, int $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não encontrado.',
            ], 404);
        }

        $avaliacoes = Avaliacao::query()
            ->where('id_avaliado', $usuario->id_usuario)
            ->select([
                'id_avaliacao',
                'id_proposta',
                'id_avaliador',
                'id_avaliado',
                'nr_nota',
                'ds_comentario',
                'created_at',
            ])
            ->with('avaliador:id_usuario,nm_usuario,ds_foto_perfil')
            ->orderByDesc('created_at')
            ->orderByDesc('id_avaliacao')
            ->get();

        $media = $avaliacoes->isEmpty()
            ? 0
            : round((float) $avaliacoes->avg('nr_nota'), 2);
        $quantidade = $avaliacoes->count();

        return response()->json([
            'avaliacoes' => $avaliacoes,
            'media' => $media,
            'quantidade' => $quantidade,
            'destaque' => $media >= 4.5 && $quantidade >= 3,
        ], 200);
    }
}
