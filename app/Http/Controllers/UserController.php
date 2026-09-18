<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();

        return response()->json($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_usuario' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:tb_usuario,email',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $usuario = User::create([
            'nm_usuario' => $request->nm_usuario,
            'email' => $request->email,
            'password' => $request->password,

            // Cliente padrão
            'tp_usuario' => 'C',

            // Usuário ativo
            'st_usuario' => 'A',

            // Ainda não confirmou email
            'st_email_verificado' => 'N',
        ]);

        return response()->json([
            'message' => 'Usuário cadastrado com sucesso!',
            'usuario' => $usuario
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        return response()->json($usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * Atualiza:
     * - Nome
     * - Descrição
     * - Foto de perfil
     * - Banner
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'nm_usuario' => 'nullable|string|max:100',
            'ds_usuario' => 'nullable|string|max:500',

            // Foto de perfil
            'ds_foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',

            // Banner
            'ds_banner' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Atualiza nome e descrição
        $usuario->nm_usuario = $request->nm_usuario ?? $usuario->nm_usuario;
        $usuario->ds_usuario = $request->ds_usuario ?? $usuario->ds_usuario;

        /*
        |--------------------------------------------------------------------------
        | FOTO DE PERFIL
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('ds_foto_perfil')) {

            // Apaga a foto antiga, caso exista
            if ($usuario->ds_foto_perfil) {
                Storage::disk('public')->delete($usuario->ds_foto_perfil);
            }

            // Salva a nova foto
            $caminhoFoto = $request->file('ds_foto_perfil')
                ->store('usuarios/perfis', 'public');

            $usuario->ds_foto_perfil = $caminhoFoto;
        }

        /*
        |--------------------------------------------------------------------------
        | BANNER
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('ds_banner')) {

            // Apaga o banner antigo, caso exista
            if ($usuario->ds_banner) {
                Storage::disk('public')->delete($usuario->ds_banner);
            }

            // Salva o novo banner
            $caminhoBanner = $request->file('ds_banner')
                ->store('usuarios/banners', 'public');

            $usuario->ds_banner = $caminhoBanner;
        }

        // Salva todas as alterações
        $usuario->save();

        return response()->json([
            'message' => 'Usuário atualizado com sucesso!',
            'usuario' => $usuario->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * UC03 - Excluir conta
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        try {

            DB::transaction(function () use ($usuario) {

                $idUsuario = $usuario->id_usuario;

                /*
                |--------------------------------------------------------------------------
                | 1. DESCOBRE OS PRODUTOS DO USUÁRIO
                |--------------------------------------------------------------------------
                */

                $produtos = DB::table('tb_produto')
                    ->where('id_usuario', $idUsuario)
                    ->pluck('id_produto')
                    ->toArray();

                /*
                |--------------------------------------------------------------------------
                | 2. REMOVE DADOS QUE DEPENDEM DIRETAMENTE DO USUÁRIO
                |--------------------------------------------------------------------------
                */

                // Avaliações feitas pelo usuário
                DB::table('tb_avaliacao')
                    ->where('id_usuario', $idUsuario)
                    ->delete();

                // Denúncias feitas pelo usuário
                DB::table('tb_denuncia')
                    ->where('id_usuario', $idUsuario)
                    ->delete();

                // Favoritos do usuário
                DB::table('tb_favorito')
                    ->where('id_usuario', $idUsuario)
                    ->delete();

                // Histórico de interações do usuário
                DB::table('tb_historico_interacao')
                    ->where('id_usuario', $idUsuario)
                    ->delete();

                // Notificações do usuário
                DB::table('tb_notificacao')
                    ->where('id_usuario', $idUsuario)
                    ->delete();

                // Mensagens enviadas pelo usuário
                DB::table('tb_mensagem')
                    ->where('id_usuario', $idUsuario)
                    ->delete();

                /*
                |--------------------------------------------------------------------------
                | 3. REMOVE PROPOSTAS DO USUÁRIO
                |--------------------------------------------------------------------------
                */

                $propostas = DB::table('tb_proposta')
                    ->where('id_solicitante', $idUsuario)
                    ->orWhere('id_destinatario', $idUsuario)
                    ->pluck('id_proposta')
                    ->toArray();

                /*
                |--------------------------------------------------------------------------
                | 4. REMOVE MENSAGENS DAS PROPOSTAS
                |--------------------------------------------------------------------------
                */

                if (!empty($propostas)) {
                    DB::table('tb_mensagem')
                        ->whereIn('id_proposta', $propostas)
                        ->delete();
                }

                /*
                |--------------------------------------------------------------------------
                | 5. REMOVE ITENS DAS PROPOSTAS
                |--------------------------------------------------------------------------
                */

                if (!empty($propostas)) {
                    DB::table('tb_item_proposta')
                        ->whereIn('id_proposta', $propostas)
                        ->delete();
                }

                /*
                |--------------------------------------------------------------------------
                | 6. REMOVE AS PROPOSTAS
                |--------------------------------------------------------------------------
                */

                if (!empty($propostas)) {
                    DB::table('tb_proposta')
                        ->whereIn('id_proposta', $propostas)
                        ->delete();
                }

                /*
                |--------------------------------------------------------------------------
                | 7. REMOVE DADOS RELACIONADOS AOS PRODUTOS
                |--------------------------------------------------------------------------
                */

                if (!empty($produtos)) {

                    // Avaliações relacionadas aos produtos
                    DB::table('tb_avaliacao')
                        ->whereIn('id_produto', $produtos)
                        ->delete();

                    // Denúncias relacionadas aos produtos
                    DB::table('tb_denuncia')
                        ->whereIn('id_produto', $produtos)
                        ->delete();

                    // Favoritos relacionados aos produtos
                    DB::table('tb_favorito')
                        ->whereIn('id_produto', $produtos)
                        ->delete();

                    // Histórico relacionado aos produtos
                    DB::table('tb_historico_interacao')
                        ->whereIn('id_produto', $produtos)
                        ->delete();

                    // Itens de proposta relacionados aos produtos
                    DB::table('tb_item_proposta')
                        ->whereIn('id_produto', $produtos)
                        ->delete();

                    // Imagens dos produtos
                    DB::table('tb_imagem_produto')
                        ->whereIn('id_produto', $produtos)
                        ->delete();

                    /*
                    |--------------------------------------------------------------------------
                    | 8. REMOVE OS PRODUTOS
                    |--------------------------------------------------------------------------
                    */

                    DB::table('tb_produto')
                        ->whereIn('id_produto', $produtos)
                        ->delete();
                }

                /*
                |--------------------------------------------------------------------------
                | 9. REMOVE FOTO DE PERFIL
                |--------------------------------------------------------------------------
                */

                if ($usuario->ds_foto_perfil) {
                    Storage::disk('public')->delete(
                        $usuario->ds_foto_perfil
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | 10. REMOVE BANNER
                |--------------------------------------------------------------------------
                */

                if ($usuario->ds_banner) {
                    Storage::disk('public')->delete(
                        $usuario->ds_banner
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | 11. REMOVE O USUÁRIO
                |--------------------------------------------------------------------------
                */

                $usuario->delete();
            });

            return response()->json([
                'message' => 'Usuário excluído com sucesso!'
            ], 200);

        } catch (\Throwable $e) {

            return response()->json([
                'message' => 'Não foi possível excluir o usuário.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}