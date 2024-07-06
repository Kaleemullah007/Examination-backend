<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\EmailRequest;
use App\Http\Requests\Api\registerRequest;
use App\Http\Requests\VarificationRequest;
use App\Models\User;
use App\Notifications\EmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(AuthRequest $request)
    {

        // Checking User

        $user = User::whereEmail($request->email)->where('role', 'user')->first();
        if (is_null($user)) {
            return response()->json(['errors'=>['message' => 'No email exist in the system','error_type'=>'invalid']], 401);
        }

        if ($user->email != $request->email && $user->password != Hash::check($user->password, $request->password)) {
            return response()->json(['message' => 'Bad credentials','error_type'=>'invalid'], 401);
        }

        if (is_null($user->email_verified_at)) {
            return response()->json(['message' => 'Email is not verified yet, Please verify it','error_type'=>'not_varified'], 401);
        }

        

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->noContent();
    }

    public function register(registerRequest $request){

        $user  = User::create($request->validated());
        $user->notify(new EmailVerification($user));
        return response()->json(['message'=>'successfully created account']);

    }


    public function varification(EmailRequest $request)
    {

        // Checking User

        $user = User::whereEmail($request->email)->first();
        if (is_null($user)) {
            return response()->json(['errors'=>['message' => 'Invalid Email, Try Again']], 400);
        }

        
        elseif (!is_null($user->email_verified_at)) {
            return response()->json(['errors'=>['message' => 'Email is already varified, login with valid credentials']], 400);
        }

        elseif ($user->code != $request->code) {
            return response()->json(['errors'=>['message' => 'Invalid Code, Try Again'.$user->email_verified_at]], 400);
        }

        $user->email_verified_at = now();
        $user->code = null;
        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function sendcode(registerRequest $request){

        $user = User::whereEmail($request->email)->first();
       
        $user->notify(new EmailVerification($user));
        return response()->json(['message'=>'Send code to your email']);

    }
    
}
