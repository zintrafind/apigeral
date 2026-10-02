<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DadosPessoaisController extends Controller
{
    public function update(Request $request, $id)
    {
        // O usuário é identificado pelo token do Sanctum.
        $usuario = $request->user();

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuário não autenticado.',
            ], 401);
        }

        // Impede que alguém altere os dados de outra conta.
        if ((string) $usuario->id_usuario !== (string) $id) {
            return response()->json([
                'message' => 'Você só pode alterar seus próprios dados.',
            ], 403);
        }

        if ($usuario->st_usuario === 'B') {
            return response()->json([
                'message' => 'Sua conta está bloqueada.',
            ], 403);
        }

        // Remove espaços somente do e-mail.
        if (is_string($request->input('email'))) {
            $request->merge([
                'email' => trim($request->input('email')),
            ]);
        }

        // Se qualquer campo de senha for enviado,
        // exige o preenchimento dos três.
        $alterandoSenha = $request->hasAny([
            'senha_atual',
            'password',
            'password_confirmation',
        ]);

        $regras = [
            'email' => [
                'bail',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('tb_usuario', 'email')
                    ->ignore($usuario->id_usuario, 'id_usuario'),
            ],
        ];

        if ($alterandoSenha) {
            $regras['senha_atual'] = [
                'required',
                'string',
            ];

            $regras['password'] = [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:senha_atual',
            ];

            $regras['password_confirmation'] = [
                'required',
                'string',
            ];
        }

        $validator = Validator::make(
            $request->all(),
            $regras,
            [
                'email.required' => 'Informe um endereço de e-mail.',
                'email.string' => 'Informe um e-mail válido.',
                'email.email' => 'Informe um e-mail válido.',
                'email.max' => 'O e-mail deve ter até 255 caracteres.',
                'email.unique' => 'Este e-mail já está sendo usado por outra conta.',

                'senha_atual.required' => 'Informe sua senha atual.',
                'senha_atual.string' => 'A senha atual deve ser um texto válido.',

                'password.required' => 'Informe a nova senha.',
                'password.string' => 'A nova senha deve ser um texto válido.',
                'password.min' => 'A nova senha deve possuir pelo menos 8 caracteres.',
                'password.confirmed' => 'A confirmação da nova senha não corresponde.',
                'password.different' => 'A nova senha deve ser diferente da senha atual.',

                'password_confirmation.required' => 'Confirme a nova senha.',
                'password_confirmation.string' => 'A confirmação deve ser um texto válido.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $dados = $validator->validated();

        if ($alterandoSenha) {
            if (!Hash::check($dados['senha_atual'], $usuario->password)) {
                return response()->json([
                    'message' => 'A senha atual está incorreta.',
                ], 422);
            }

            $usuario->password = Hash::make($dados['password']);
        }

        if ($usuario->email !== $dados['email']) {
            // O novo endereço ainda não foi verificado.
            $usuario->st_email_verificado = false;
        }

        $usuario->email = $dados['email'];
        $usuario->save();

        // Retorna apenas os dados necessários para esta tela.
        return response()->json([
            'message' => 'Seus dados pessoais foram atualizados com sucesso.',
            'usuario' => [
                'id_usuario' => $usuario->id_usuario,
                'email' => $usuario->email,
            ],
        ]);
    }
}