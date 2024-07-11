<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $loginRequest)
    {
        $authenticationData = $loginRequest->validated();
        if (Auth::attempt(
            credentials: [
            'login' => $authenticationData['login'],
            'password' => $authenticationData['password']
        ],
            remember: $authenticationData['remember']
        )) {
            $loginRequest->session()->regenerate();
            return redirect('/');
        }

        return response()->json(['message' => 'Неверный логин или пароль'], 400);
    }
}
