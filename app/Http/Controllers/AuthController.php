<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Necessário para consultar a tb_usuario se não usar Model dedicado

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Busca o usuário diretamente na tabela tb_usuario do seu SQL
        $usuario = DB::table('tb_usuario')->where('email', $dados['email'])->first();

        // Verifica se o usuário existe e se a senha confere
        if (!$usuario || !Hash::check($dados['password'], $usuario->password)) {
            return response()->json([
                'message' => 'Email ou senha inválidos'
            ], 401);
        }

        // Verifica se o usuário está ativo (opcional, baseado na sua coluna st_usuario)
        if (isset($usuario->st_usuario) && $usuario->st_usuario === 'I') {
            return response()->json([
                'message' => 'Esta conta está inativa ou bloqueada.'
            ], 403);
        }

        // Busca a instância do Model para gerar o token Sanctum
        $userModel = User::find($usuario->id_usuario);
        $token = $userModel->createToken('api-token')->plainTextToken;

        // Retorna os dados incluindo o tp_usuario ('A' para Admin, 'C' para Cliente)
        return response()->json([
            'message' => 'Login realizado com sucesso!',
            'token' => $token,
            'usuario' => [
                'id_usuario' => $usuario->id_usuario,
                'nm_usuario' => $usuario->nm_usuario,
                'email' => $usuario->email,
                'tp_usuario' => $usuario->tp_usuario, // 🌟 Essencial para o Painel Web saber se é Admin
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!'
        ]);
    }
}
