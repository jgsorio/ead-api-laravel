<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $validate = Validator::make($request->all(),
            ['email' => ['required', 'email']],
            [
                'required' => "O email é orbigatório",
                'email' => "O email precisa ser válido"
            ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->getMessageBag()], 400);
        }

        $status = Password::sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(['status' => $status]);
        }

        return response()->json(['email' => __($status)], 422);
    }

    public function resetPassword(Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                'email' => ['required', 'email'],
                'token' => ['required'],
                'password' => ['required', 'min:5', 'max:30']
            ],
            [
                'email.required' => "O email é orbigatório",
                'email' => "O email precisa ser válido",
                'token.required' => "O token é obrigatório",
                'password.required' => "A senha é obrigatória",
                'password.min' => "A senha precisa ter no mínimo 5 caracteres",
                'password.max' => "A senha precisa ter no máximo 30 caracteres"
            ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->getMessageBag()], 400);
        }

        $status = Password::reset($request->only('email', 'password', 'token'), function($user, $password) {
            $user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));
            $user->save();

            event(new PasswordReset($user));
        });

        if ($status == Password::PASSWORD_RESET) {
            return response()->json([ 'message' => "Senha alterada com sucesso" ]);
        }

        return response()->json([ 'error' => __($status)], 400);
    }
}
