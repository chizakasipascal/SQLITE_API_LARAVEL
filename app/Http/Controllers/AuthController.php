<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), $validatedData);
        if ($validator->fails()) {
            return response()->json([
                'Message'=>'Parametre manquant',
                'Error'=>$validator->errors()
            ], 401);
        } else {
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


    public function Login(Request $request)
    {
        $validatedData = array(
            'email'=>'required', 
            'password'=>'required',
        );
        $validator = Validator::make($request->all(), $validatedData);
        if ($validator->fails()) {
            return response()->json([
                'Message'=>'Parametre manquant',
                'Error'=>$validator->errors()
            ], 401);
        } else {

            //Check email 
            $user=User::where('email',$request->email)->first();

            //Check password
            if(!$user || !Hash::check($request->password,$user->passwrod)){
                return response([
                    'Message'=>['Uttilisateur not trouver'],
                    'USER ERROR'=>$user,
                ],404);
            }
            
            
            $token=$user->createToken($request->password)->plainTextToken;
    
            $response=[ 
                'user'=>$user,
                'token'=>$token
            ];
    
            return response($response,201);
        }
       
    }
}
