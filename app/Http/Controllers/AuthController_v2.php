<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLogin;
use App\Http\Requests\UserRegister;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController_v2 extends Controller
{
    //
    public function register(UserRegister $request){
        $validate= $request->validated();
        $user = User::create($validate);
        return response()->json([
            "code"=>"successfully",
            "user"=>$user
        ],200);
    }

    public function login(UserLogin $request){
        $validate = $request->validated();
//        dd($validate);
        if(auth('web')->attempt($validate)){
            $user=auth()->user();
            $token=$user->createToken('to do list')->plainTextToken;
            return response()->json([
                "code"=>"successfully",
                "data"=>$user,
                "token"=>$token
            ],200);
        }else{
            return response()->json([
                "code"=>"login failed",
                "message"=>"username or password are not correct"
            ],500);


        }
    }
    public function getDetail(){
        $user= \auth()->user();
        return response()->json([
            "code"=>"successfully",
            "datta"=>$user
        ],200);
    }
}
