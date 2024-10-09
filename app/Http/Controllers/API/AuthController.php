<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*public function login(request $request)
    {
        try{
            $data = $request->all();
            $creds = [
                'email' => $data['email'],
                'password' => $data['password'],
            ];
            $res = Auth::attempt($creds);
            return response()->json([
                "msg" => "You are in",
                "success" => true,
                "data" => $res
            ],200);

        }catch (Exception $e)

        {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ]);
        }
    }*/

    public function login(Request $request)
    {
        $creds = $request->only('email', 'password');
        $email = $creds['email'];
        $password = $creds['password'];
        $userExists = User::Where('email', $email)->first();
        if (!$userExists)
        {
            return response()->json([
                "msg" => 'Invalid email',
                "success" => false,
                "data" => []
            ],401);
        }
        if(!Hash::check($password, $userExists->password))
        {
            return response()->json([
                "msg" => 'Wrong password',
                "success" => false,
                "data" => []
            ],401);
        }
        $token = $userExists->createToken('my-app-token')->plainTextToken;
        return response()->json([
            'msg' => 'You are logged in',
            'success' => true,
            'data' => [
                'token' => $token,
                'user' => $userExists
            ]
        ], 200);
    }

    public function signup(request $request)
    {
        try {
            $data = $request->all();
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);

            $user->save();

            return response()->json([
                "msg" => "You are in",
                "success" => true,
                "data" => ['user'=>$user]
                ],200);
        }catch (Exception $e){
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ]);
        }

    }


    public function logout(request $request)
    {
       try {
            $user = $request->user();
            if ($user)
            {
                $user->currentAccessToken()->delete();
            }
            return response()->json([
                "msg" => "You are logged out",
                "success" => true,
                "data" => []
            ],200);
        }catch (Exception $e){
           return response()->json([
               "msg" => $e->getMessage(),
               "success" => false,
               "data" => []
           ]);
       }
    }
}
