<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

       $user = User::where('email', $request->email)->first();

       if (!$user || ! Hash::check($request->password, $user->password)) {
           return response([
               'message' => ['password atau email salah']
           ], 404);
       }

       return response([
           'message' => 'login berhasil',
           'token' => $user->createToken('token')->plainTextToken
       ], 200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'logout berhasil'
        ], 200);
    }

    public function profile(Request $request){
        return $request->user();
    }

    //register user
    public function register(Request $request){
        $request->validate([
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response([
            'message' => 'register berhasil',
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ], 200);

    }

}
