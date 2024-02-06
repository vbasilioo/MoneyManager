<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(){
        try{
            $accounts = Account::all();
            
            if($accounts->isEmpty())
                return ApiResponse::error('No accounts registered.');

            return ApiResponse::success($accounts, 'Accounts listed.');
        }catch(\Exception $error){
            return ApiResponse::error('Failed to fetch accounts.');
        }
    }

    public function show($id){
        try{
            $account = Account::findOrFail($id);

            return ApiResponse::success($account, 'Account found.');
        }catch(\Exception $error){
            return ApiResponse::error('Account not found.', 404);
        }
    }

    public function store(Request $request){
        try{
            $this->validate($request, [
                'user_id' => 'required|exists:users,id',
                'name' => 'required',
                'description' => 'required',
                'type' => 'required',
                'payment_date' => 'required',
                'fees' => 'required',
            ]);

            $account = Account::create([
                'user_id' => $request->input('user_id'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'type' => $request->input('type'),
                'account_date' => now(),
                'payment_date' => $request->input('payment_date'),
                'fees' => $request->input('fees'),
            ]);

            return ApiResponse::success($account, 'Account created successfully.', 201);
        }catch(\Exception $error){
            return ApiResponse::error('Failed to create an account.', $error->getMessage());
        }
    }
}