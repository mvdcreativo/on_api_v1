<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\User;


class SocialAuthController extends AuthController
{
    private function loginS($user)
    {   
        // return "user".$user;
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
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

    function loginSocial(Request $request)
    {
        $provider = $request->provider;
        
        if($provider == "GOOGLE"){
            $social_token = $request->idToken;
            $social_client = new Client();
            $url_social_validation = 'https://oauth2.googleapis.com/tokeninfo?id_token='.$social_token;
        
            $res = $social_client->request('GET',$url_social_validation);
            $response = json_decode($res->getBody(), true);

            $user_excist = User::where('email', $response['email'])->first();
            ///si existe logeamos y devolvemos token
            if($user_excist){
                $user_excist->social_id = $response['sub'];
                $user_excist->save();
                
                return $this->loginS($user_excist);
            }else{
            /// si no existe creamos usuario
                $user = new User([
                    'name'     => $response['given_name'],
                    'last_name' => $response['family_name'],
                    'email'    => $response['email'],
                    'password' => bcrypt($response['at_hash']),
                    'social_id' => $response['sub'],
                ]);
                $request_user = new Request($user->toArray());
                $this->store($request_user);

                if($user){
                    return $this->loginS($user);
                };
                
            }
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        ////////////


        if($provider == "FACEBOOK"){
            $social_token = $request->authToken;
            $social_client = new Client();
            $social_id = $request->id;
            $url_social_validation = 'https://graph.facebook.com/'.$social_id.'?fields=email,first_name,last_name,name&access_token='.$social_token;
        
            $res = $social_client->request('GET',$url_social_validation);
            $response = json_decode($res->getBody(), true);
            
            $user_excist = User::where('email', $response['email'])->first();
            ///si existe logeamos y devolvemos token
            if($user_excist){
                $user_excist->social_id = $response['id'];
                $user_excist->save();

                return $this->loginS($user_excist);
            }else{
            /// si no existe creamos usuario
                $user = new User([
                    'name'     => $response['first_name'],
                    'last_name' => $response['last_name'],
                    'email'    => $response['email'],
                    'password' => bcrypt("pass!!x900".$response['id']),
                    'social_id' => $response['id'],
                ]);
                $request_user = new Request($user->toArray());
                $this->store($request_user);
                if($user){
                    return $this->loginS($user);
                };
            }
        return response()->json(['message' => 'Unauthorized'], 401);

        }
    }
}
