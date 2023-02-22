<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $credentials = $request->validate([
            'name'=>'required|string|min:3',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:6'
        ]);

        $credentials['password'] = Hash::make($request->password);

        $user = User::create([
            'name'=>$credentials['name'],
            'email'=>$credentials['email'],
            'password'=>$credentials['password']
        ]);

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token
        ];

        return response($response,201);

    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:6'
        ]);

        if(!Auth::attempt($credentials)){
            return response('invalid login', Response::HTTP_UNAUTHORIZED);
        }

        return response(['user'=>Auth::user()],200);
    }

    public function logout(Request $request){
        
        auth()->user()->tokens()->delete();

        return 'logged out';
        
    }


}
