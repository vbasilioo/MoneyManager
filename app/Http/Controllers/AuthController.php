<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request){
        $credentials = $request->only('username', 'password');

        if(Auth::attempt($credentials)){
            return response()->json(['message' => 'Autenticação realizada com sucesso.']);
        }

        return response()->json(['message' => 'Credenciais inválidas.'], 401);
    }
}
