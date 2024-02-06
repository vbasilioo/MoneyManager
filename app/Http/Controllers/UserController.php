<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        try{
            $users = User::all();

            if($users->isEmpty())
                return ApiResponse::success(null, 'No users found.');

            return ApiResponse::success($users, 'Users listed.');
        }catch(\Exception $error){
            return ApiResponse::error('Failed to fetch users.');
        }
    }

    public function show($id){
        try{
            $user = User::findOrFail($id);

            return ApiResponse::success($user, 'User found.');
        }catch(\Exception $error){
            return ApiResponse::error('User not found.', 404);
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

            return ApiResponse::success($user, 'User created successfully.', 201);
        }catch(\Illuminate\Validation\ValidationException $validationException){
            $errors = $validationException->validator->errors()->all();
            return ApiResponse::error(implode(' ', $errors), 422);
        }catch(\Exception $error){
            return ApiResponse::error('Failed to create a user.' . $error->getMessage());
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

            return ApiResponse::success($user, 'User updated successfully.');
        }catch(\Exception $error){
            return ApiResponse::error('Failed to update the user.');
        }
    }

    public function destroy($id){
        try{
            $user = User::findOrFail($id);

            $user->delete();

            return ApiResponse::success(null, 'User deleted successfully.');
        }catch(\Exception $error){
            return ApiResponse::error('Failed to delete the user.');
        }
    }
}