<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\ApiResponse;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(){
        try{
            $users = User::all();

            if($users->isEmpty())
                return ApiResponse::success(null, 'Nenhum usuário encontrado.');

            return ApiResponse::success($users, 'Usuários listados.');
        }catch(\Exception $error){
            return ApiResponse::error('Falha ao buscar os usuários.');
        }
    }

    public function show($id){
        try{
            $user = User::findOrFail($id);

            return ApiResponse::success($user, 'Usuário encontrado.');
        }catch(\Exception $error){
            return ApiResponse::error('Usuário não encontrado.', 404);
        }
    }

    public function store(Request $request){
        try{
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            return ApiResponse::success($user, 'Usuário criado com sucesso.', 201);
        }catch(\Illuminate\Validation\ValidationException $validationException){
            $errors = $validationException->validator->errors()->all();
            return ApiResponse::error(implode(' ', $errors), 422);
        }catch(\Exception $error){
            return ApiResponse::error('Falha ao criar um usuário.' . $error->getMessage());
        }
    }

    public function update(Request $request, $id){
        try{
            $this->validate($request, [
                'name' => 'string',
                'email' => [
                    'email',
                    Rule::unique('users')->ignore($id),
                ],
                'password' => 'min:6'
            ]);

            $user = User::findOrFail($id);

            $user->update($request->all());

            return ApiResponse::success($user, 'Usuário atualizado com sucesso.');
        }catch(\Exception $error){
            return ApiResponse::error('Falha ao atualizar o usuário.');
        }
    }

    public function destroy($id){
        try{
            $user = User::findOrFail($id);

            $user->delete();

            return ApiResponse::success(null, 'Usuário excluído com sucesso.');
        }catch(\Exception $error){
            return ApiResponse::error('Falha ao excluir o usuário.');
        }
    }
}
