<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\UserAPIController;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthController extends UserAPIController
{
    ///REGISTRO
    public function signup(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'last_name'=> 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        
        // $password = bcrypt($request->get('password')) ;
         
        // $request['password'] = bcrypt($password);
        $user = $this->store($request);

        if(isset($user)){
            
            $newUser =  $this->login($request);
        };
        return response()->json([
            'user' => $newUser->original,
            'message' => 'Successfully created user!'
        ], 201);
    }

    //LOGIN
    public function login(Request $request )
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            // 'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'], 401);
        }
        $user = $request->user();
        $user->account;
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        //
            $remember_me = true;
        //
        if ($remember_me) {
            $token->expires_at = Carbon::now()->add(1,'minute');
        }
        $token->save();
        // dd($tokenResult);

        return response()->json([
            'token' => $tokenResult->accessToken,
            // 'refresh_token' => $tokenResult->refreshToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
            'user' => $user
        ]);
    }

    //LOGOUT
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 
            'Successfully logged out']);
    }

    // //USUARIO
    // public function user(Request $request)
    // {
    //     return response()->json($request->user());
    //     // return User::all();
    // }
    //USUARIO
    public function user(Request $request)
    {
        // $user = $request->user();
        $user = Auth::user()->load('account');
        
        return response()->json($user);
        // return User::all();
    }
}
