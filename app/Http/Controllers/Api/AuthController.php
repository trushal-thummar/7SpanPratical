<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Auth
use Auth;

//DateTime
use Carbon\Carbon;

//Models
use App\User;

class AuthController extends Controller
{
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
    	// Validate Request
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
            'remember_me' => 'boolean'
        ]);

        //Verify User Authetication Details
        $userCredentials = request(['email', 'password']);

        if(!Auth::attempt($userCredentials)){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        //Get User Detail
        $user = $request->user();

        //Create Personal Access Token
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        // Set Expiration Time
        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        //Save Token Detail
        $token->save();

        //API Response With Access Token, Token Type and Expiration Time
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
    	//Reveke Access Token
        $request->user()->token()->revoke();

        //API Response 
        return response()->json([
            'message' => 'Success! User logged out.'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
    	//API Response 
        return response()->json($request->user());
    }
}
