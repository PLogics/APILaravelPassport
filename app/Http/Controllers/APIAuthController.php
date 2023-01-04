<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class APIAuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('Token')->accessToken;
        return response()->json(['token'=>$token,'userData'=>$user],200);
    }

    public function login(Request $request)
    {
        //first do authorization//
        $data = [
            'email'=>$request->email,
            'password'=>$request->password
        ];

        if(auth()->attempt($data)){
            $token = auth()->user()->createToken('Token')->accessToken;
            return response()->json(['token'=>$token],200);
        }else{
            return response()->json(['error'=>'unauthorized'],401);
        }
    }

    public function userInfo()
    {
        $user = auth()->user();
        return response()->json(['user'=>$user],200);
    }
}

