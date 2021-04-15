<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $validatedData = array(
            'name'=>'required|string',
            'email'=>'required|string |unique:users,email', 
            'password'=>'required|string|confirmed',
        );
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email, 
            'password'=>bcrypt($request->password) ,
        ]);
        $token=$user->createToken($request->password)->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        
        return response($response,201);
    }
}
