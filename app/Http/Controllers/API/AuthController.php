<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;    

class AuthController extends Controller
{
    public function register(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'massage' => 'Validasi gagal',
                'data' => $validation->errors()
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

         return response()->json([
                'success' => true,
                'massage' => 'Register success',
                'data' => $success
            ]);
    }

    public function login(Request $request){
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;

            return response()->json([
                'success' => true,
                'massage' => 'Login success',
                'data' => $success
            ]);

        }else{

            return response()->json([
                'success' => false,
                'massage' => 'Email atau password salah',
                'data' => null
            ]);
        }

    }
}