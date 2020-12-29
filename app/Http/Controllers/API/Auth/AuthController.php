<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\UserAPIController;
use App\Http\Requests\API\CreateUserAPIRequest;
use App\Mail\Notificaciones;
use Carbon\Carbon;
use Illuminate\Http\Request;
USE Illuminate\Support\Facades\Mail;


use Illuminate\Support\Facades\Auth;

class AuthController extends UserAPIController
{
    ///REGISTRO
    public function signup(CreateUserAPIRequest $request)
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


            //////////NOtificacion al mail
            $mail_destino = $user->email;
            $msg = [
                'subject' => 'On Capacitaciones - Registro existoso',
                'title' => 'Gracias por registrarte!!!',
                'paragraph' => [
                    'Nuestra misión es la educación, cambiar vidas nuestra pasión.',
                    'Te apoyaremos con nuestro staff de educadores y nuestras instalaciones están a tú disposición.',
                    'No dudes en ponerte en contacto con nosotros para informarte.'
                ],
                // 'button' => [ 
                //     'button_name' => 'Crear contraseña',
                //     'button_link' => url('/api/password/find/'.$passwordReset->token)
                // ]
            ];
            Mail::to($mail_destino)->queue(new Notificaciones($msg));
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
