<?php

namespace App\Http\Controllers\Api;

use App\Factories\UserFactory;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, UserFactory $factory)
    {
        $user = $factory->create($request->all());

        $tokenResult = $user->createToken('authToken');
        $accessToken = $tokenResult->accessToken;
        $userType = $user->roles->pluck('name');

        return response()->json([
            'message' => 'User Successfully created',
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user_type' => $userType
        ]);
    }

    public function login(LoginRequest $request)
    {
        $guard = auth()->guard('web');
        if (!$guard->attempt($request->all())) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 404);
        }

        $user = $guard->user();
        $role = $user->roles->pluck('name');
        if ($role != 'admin'
            && $user->status == 0 ) {
            return response()->json([
                'message' => 'Your account requires approval, please contact admin.'
            ]);
        }

        $tokenResult = $user->createToken('authToken');
        $accessToken = $tokenResult->accessToken;

        return response()->json([
            'message' => 'User Successfully Logged In',
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user_type' => $role
        ]);
    }

    public function logout()
    {
        $user = auth()->user()->token();
        $user->revoke();

        return response()->json([
            'message' => 'User Logout Successfully'
        ]);
    }
}