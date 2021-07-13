<?php

namespace App\Http\Controllers;

use App\Models\Core\User;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function login(Request $request){
        $userServices = new UserServices();
        $user = User::where('email', $request->email)->first();
        $appId = $request->appId;
        if(!$user || !Hash::check($request->password,$user->password)){
            return response([
                'message' => ['These credentials do not match our record.']
            ],404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;
       // $permission = $userServices->getMenuPermission($user->id, $appId);

        $response = [
            'user' => $user,
            'token' => $token,
            //'permission' => $permission
        ];

        return response($response,201);
    }

    function logout(Request $request){
        $request->user()->tokens()->delete();


        $message = [
            'message' => 'logout user complete!'
        ];
        return response($message,201);
    }

    function user (){
        $user = Auth::user();
    }
}
