<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:users|min:2|max:100',
            'email'=>'required|unique:users',
            'password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:password'
        ]);
        if($validator->fails()){
            return response()->json([
                "message"=>"invalid",
                "error"=>$validator->errors()
            ],422);
        }
        $user= User::create([
            'name'=> $request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        return response()->json([
            "message"=>"registration",
            "data"=>$user
        ],200);
    }
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([ 'message' => 'Invalid credential' ]);
            }

            $check = Hash::check($request->password, $user->password);
            if (!$check) {
                return response()->json([ 'message' => 'Invalid credential' ]);
            }

            $accessToken = AccessToken::updateOrCreate(
                [ 'user_id' => $user->id ],
                [ 'access_token' => Str::random(255) ]
            );
            return response()->json([ 'access_token' =>  $accessToken->access_token ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function logout(Request $request)
    {
        try {
            $accessToken = AccessToken::where('access_token', $request->access_token)->first();
            if ($accessToken) {
                $accessToken->delete();
                return response()->json([ 'success' => true ]);
            }

            return response()->json([ 'success' => false ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
