<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(
                ['email' => 'Usuário e/ou senha inválidos']
            );
        }

        // Deletar todos os tokens
        $user->tokens()->delete();
        // Criar um novo token
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->Json(['token' => $token]);
    }
}
