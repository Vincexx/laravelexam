<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $validator= Validator::make($request->all(), [
                'email' => 'required|string|email|unique:users',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Email is already taken.'
                ], 400);
            }

            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json(['message' => 'User successfully registered.'], 201);
        } catch (JWTException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function login(Request $request)
    {
        $creds = $request->only(['email', 'password']);

        try {
            if (!$token = JWTAuth::attempt($creds)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json(['access_token' => $token], 200);
    }
}
