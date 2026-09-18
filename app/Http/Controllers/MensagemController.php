<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Models\Proposta;
use Illuminate\Http\Request;

class MensagemController extends Controller
{
    /**
     * Listar as mensagens de uma proposta.
     */
    public function index(Request $request, $id_proposta)
    {
        $usuario = $request->user();

        // Busca a proposta
        $proposta = Proposta::find($id_proposta);

        if (!$proposta) {
            return response()->json([
                'message' => 'Proposta não encontrada.'
            ], 404);
        }

        // Verifica se o usuário participa da proposta
        if (
            $proposta->id_solicitante !== $usuario->id_usuario &&
            $proposta->id_destinatario !== $usuario->id_usuario
        ) {
            return response()->json([
                'message' => 'Você não participa desta conversa.'
            ], 403);
        }

        // Busca as mensagens da proposta
        $mensagens = Mensagem::with('usuario')
            ->where('id_proposta', $id_proposta)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'mensagens' => $mensagens
        ], 200);
    }

    /**
     * Enviar uma nova mensagem.
     *
     * Pode enviar:
     * - somente texto;
     * - somente imagem;
     * - texto + imagem.
     */
    public function store(Request $request, $id_proposta)
    {
        /*
         * Validação.
         *
         * ds_mensagem agora é opcional porque
         * uma mensagem pode conter somente imagem.
         *
         * imagem também é opcional porque
         * uma mensagem pode conter somente texto.
         */
        $validatedData = $request->validate([
            'ds_mensagem' => 'nullable|string|max:1000',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $usuario = $request->user();

        // Busca a proposta
        $proposta = Proposta::find($id_proposta);

        if (!$proposta) {
            return response()->json([
                'message' => 'Proposta não encontrada.'
            ], 404);
        }

        // Verifica se o usuário participa da proposta
        if (
            $proposta->id_solicitante !== $usuario->id_usuario &&
            $proposta->id_destinatario !== $usuario->id_usuario
        ) {
            return response()->json([
                'message' => 'Você não participa desta conversa.'
            ], 403);
        }

        /*
         * Obtém o texto.
         *
         * Se não foi enviado, fica como null.
         */
        $texto = trim((string) $request->input('ds_mensagem', ''));

        /*
         * Verifica se existe imagem.
         */
        $temImagem = $request->hasFile('imagem');

        /*
         * Impede o envio de uma mensagem completamente vazia.
         *
         * É permitido:
         * - texto;
         * - imagem;
         * - texto + imagem.
         *
         * Não é permitido:
         * - nada.
         */
        if ($texto === '' && !$temImagem) {
            return response()->json([
                'message' => 'A mensagem não pode estar vazia.'
            ], 422);
        }

        /*
         * Caminho da imagem.
         *
         * Começa como null porque a mensagem
         * pode ser somente texto.
         */
        $caminhoImagem = null;

        /*
         * Se foi enviada uma imagem, salva no
         * mesmo disco público utilizado pelas
         * imagens dos produtos.
         *
         * A pasta será:
         *
         * storage/app/public/mensagens
         */
        if ($temImagem) {
            $caminhoImagem = $request
                ->file('imagem')
                ->store('mensagens', 'public');
        }

        /*
         * Cria a mensagem no banco.
         *
         * Se não tiver texto, salva string vazia
         * em vez de null, para não violar a constraint NOT NULL.
         */
        $mensagem = Mensagem::create([
            'id_usuario' => $usuario->id_usuario,
            'id_proposta' => $proposta->id_proposta,
            'ds_mensagem' => $texto !== '' ? $texto : '',
            'ds_imagem' => $caminhoImagem,
        ]);

        /*
         * Carrega os dados do usuário que enviou
         * a mensagem.
         */
        $mensagem->load('usuario');

        return response()->json([
            'message' => 'Mensagem enviada com sucesso!',
            'mensagem' => $mensagem
        ], 201);
    }

    /**
     * Os métodos abaixo não são necessários para o UC29,
     * portanto permanecem sem implementação.
     */
    public function show(string $id)
    {
        return response()->json([
            'message' => 'Operação não implementada.'
        ], 501);
    }

    public function update(Request $request, string $id)
    {
        return response()->json([
            'message' => 'Operação não implementada.'
        ], 501);
    }

    public function destroy(string $id)
    {
        return response()->json([
            'message' => 'Operação não implementada.'
        ], 501);
    }
}
