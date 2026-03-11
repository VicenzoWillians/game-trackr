<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $throttleKey = strtolower($request->email) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            return response()->json([
                'title' => 'Oops! Encontramos um problema.',
                'message' => "Muitas tentativas de login. Tente novamente em {$seconds} segundos.",
                'status' => 'error'
            ], 429); // 429 é o código HTTP oficial para "Too Many Requests"
        }

        // Verify if the user exists and the password is correct
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($throttleKey);
            
            return response()->json([
                'title' => 'Oops! Encontramos um problema.',
                'message' => 'Credenciais inválidas. Por favor, verifique os seus dados e tente novamente.',
                'status' => 'error'
            ], 401);
        }

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'title' => 'Atenção!',
                'message' => 'Por favor, confirme o seu e-mail antes de acessar ao sistema.',
                'needs_verification' => true,
                'status' => 'warning'
            ], 403); 
        }

        // Clear the rate limiter on successful login
        RateLimiter::clear($throttleKey);

        // Create a token for the authenticated user
        // The name 'auth_token' is just an internal identifier
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the token and basic user data to the Vue frontend
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        // Revoke the current access token of the user making the request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'title' => 'Sucesso!',
            'message' => 'Sessão encerrada com sucesso.',
            'status' => 'success'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'O username é obrigatório.',
            'name.unique' => 'Este username já está sendo usado por outro jogador.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Por favor, informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está sendo utilizado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não bate com a senha informada.',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));
        });

        return response()->json([
            'title' => 'Sucesso!',
            'message' => 'Conta criada com sucesso! Por favor, verifique a sua caixa de entrada.',
            'status' => 'success'
        ], 201);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'hash' => 'required|string',
        ]);

        $user = User::findOrFail($request->id);

        // Verify if the hash of the link matches the user's actual email (Security)
        if (!hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'title' => 'Oops! Encontramos um problema.',
                'message' => 'O link de verificação é inválido ou expirou.',
                'status' => 'error'
            ], 403);
        }

        // If already verified, just notify that everything is fine
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'title' => 'Atenção!',
                'message' => 'O e-mail já foi verificado anteriormente.',
                'status' => 'info'
            ], 200);
        }

        // Mark the user's email as verified
        $user->markEmailAsVerified();

        return response()->json([
            'title' => 'Sucesso!',
            'message' => 'E-mail verificado com sucesso!',
            'status' => 'success'
        ], 200);
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'title' => 'Oops! Encontramos um problema.',
                'message' => 'Usuário não encontrado.',
                'status' => 'error'
            ], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'title' => 'Atenção!',
                'message' => 'Este e-mail já está verificado.',
                'status' => 'info'
            ], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'title' => 'Sucesso!',
            'message' => 'E-mail de verificação reenviado!',
            'status' => 'success'
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Por favor, informe o seu e-mail.',
            'email.email' => 'Informe um e-mail válido.'
        ]);

        // O Laravel verifica se o e-mail existe na tabela users, gera um token 
        // salva na tabela password_reset_tokens e dispara o e-mail!
        $status = DB::transaction(function () use ($request) {
            return Password::broker()->sendResetLink(
                $request->only('email')
            );
        });

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'title' => 'Sucesso!',
                'message' => 'Link de recuperação enviado! Por favor, verifique a sua caixa de entrada.',
                'status' => 'success'
            ], 200);
        }

        // Se falhar (ex: e-mail não existe no banco)
        return response()->json([
            'title' => 'Oops! Encontramos um problema.',
            'message' => 'Ocorreu um erro ao processar o pedido. Tente novamente mais tarde.',
            'status' => 'error'
        ], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da nova senha não confere.',
        ]);

        // 2. Transação de Banco de Dados
        $status = DB::transaction(function () use ($request) {
            return Password::broker()->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                }
            );

        });

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'title' => 'Sucesso!',
                'message' => 'Senha redefinida com sucesso!',
                'status' => 'success'
            ], 200);
        }

        return response()->json([
            'title' => 'Oops! Encontramos um problema.',
            'message' => 'O link de recuperação é inválido ou já expirou.',
            'status' => 'error'
        ], 400);
    }
}
