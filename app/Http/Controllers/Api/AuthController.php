<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try
        {
            if (! $token = auth('api')->attempt($credentials))
            {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
            $user = auth('api')->user();
            if (! $user->role || ! $user->role->status)
            {
                return response()->json(['error' => 'Your account is inactive'], 401);
            }
        }
        catch (JWTException $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'status' => 'success',
            'token'  => $token,
            'user'   => auth()->user(),
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
