<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
// use Illuminate\Http\Response;

class Authentication extends Controller
{
    function signUpHandler(Request $request){
        $newUser = new User;
        $newUser->username= $request->username;
        $newUser->email = $request->email;
        $newUser->password = Hash::make($request->password);
        $newUser->created_at = now();
        $newUser->updated_at = now();
        $newUser->save();
        return ["success" => true];
    }

    function loginHandler(Request $request){
        $user = User::where('username', $request->username)
        ->select('id','username', 'email', 'password')->get()[0];
        // return $user;
        if($user != NULL){
            //compares the input password
            if(!Hash::check($request->password, $user->password)) {return response(["message" => "User found"], 200);}
            $token = $user->createToken('secret-api-token')->plainTextToken;
            $response = ["user" => $user, "token"=>$token];
            return response($response, 200);
        };
        return response(["message" => "User not found"], 404);
    }

}
