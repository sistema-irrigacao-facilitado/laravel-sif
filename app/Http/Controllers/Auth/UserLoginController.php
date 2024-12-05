<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            "password" => "required|string",
            "email" => "required|email|max:200"
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('dashboard'); // Ajuste para a rota do dashboard do usuário
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.']);
    }

    public function showLoginForm(){
        return view('auth/user/login');
    }
}

