<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    private const CODE_TTL_MINUTES = 15;

    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $email = trim($validated['email']);
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'E-mail não encontrado.',
            ], 404);
        }

        $code = (string) random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($code),
                'created_at' => now(),
            ]
        );

        Mail::to($email)->send(new ResetPasswordCodeMail($code));

        return response()->json([
            'message' => 'Código de recuperação enviado para o seu e-mail.',
        ], 200);
    }

    public function verifyResetCode(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'code' => ['required', 'digits:6'],
        ]);

        $result = $this->validateCode(trim($validated['email']), $validated['code']);

        if ($result !== null) {
            return response()->json(['message' => $result['message']], $result['status']);
        }

        return response()->json(['message' => 'Código validado com sucesso.'], 200);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'code' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ], [
            'password.min' => 'A senha deve possuir pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da nova senha não corresponde.',
            'password_confirmation.required' => 'Confirme a nova senha.',
        ]);

        $email = trim($validated['email']);
        $result = $this->validateCode($email, $validated['code']);

        if ($result !== null) {
            return response()->json(['message' => $result['message']], $result['status']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'E-mail não encontrado.'], 404);
        }

        DB::transaction(function () use ($user, $email, $validated) {
            $user->password = Hash::make($validated['password']);
            $user->updated_at = now();
            $user->save();

            DB::table('password_reset_tokens')->where('email', $email)->delete();
        });

        return response()->json(['message' => 'Senha redefinida com sucesso.'], 200);
    }

    private function validateCode(string $email, string $code): ?array
    {
        $reset = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$reset || !Hash::check($code, $reset->token)) {
            return [
                'status' => 422,
                'message' => 'Código de recuperação inválido.',
            ];
        }

        if (!$reset->created_at || Carbon::parse($reset->created_at)->addMinutes(self::CODE_TTL_MINUTES)->isPast()) {
            return [
                'status' => 422,
                'message' => 'Código de recuperação expirado. Solicite um novo código.',
            ];
        }

        return null;
    }
}
