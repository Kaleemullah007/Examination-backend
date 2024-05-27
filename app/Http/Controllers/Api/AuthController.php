<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\registerRequest;
use App\Models\User;
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
            return response()->json(['errors'=>['message' => 'No email exist in the system']], 401);
        }

        if ($user->email != $request->email && $user->password != Hash::check($user->password, $request->password)) {
            return response()->json(['message' => 'Bad credentials'], 401);
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

        User::create($request->validated());
        return response()->json(['message'=>'successfully created account']);

    }
}
