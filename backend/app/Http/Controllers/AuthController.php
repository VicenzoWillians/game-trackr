<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
                'message' => "Muitas tentativas de login. Tente novamente em {$seconds} segundos."
            ], 429); // 429 é o código HTTP oficial para "Too Many Requests"
        }

        // Verify if the user exists and the password is correct
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($throttleKey);
            
            return response()->json([
                'message' => 'As credenciais informadas estão incorretas.'
            ], 401);
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
            'message' => 'Sessão encerrada com sucesso.'
        ]);
    }
}
