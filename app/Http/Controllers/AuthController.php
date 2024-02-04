<?php

namespace App\Http\Controllers;

use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Credenciais inválidas.', 401);
        }

        try{
            if(!$token = auth()->attempt($validator->validate())){
                $lastAttempted = Auth::getLastAttempted();

                if(!$lastAttempted){
                    return ApiResponse::error('Usuário não encontrado.', 401);
                }

                if(!Hash::check($request->input('password'), $lastAttempted)){
                    return ApiResponse::error('Senha incorreta.', 401);
                }

                return ApiResponse::error('Não autorizado. Problemas com a autenticação.', 401);
            }
        }catch(JWTException $error){
            return ApiResponse::error('Erro ao gerar o token.', 500);
        }

        return $this->responseWithToken($token);
    }

    protected function responseWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }    
}
