<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (($token = Auth::attempt($input, true)) && !Auth::user()->is_block) {
            $payload = auth()->payload();
            return response()->json(api_resualt_common([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expire_at' => $payload('exp'),
                'user' => Auth::user()
            ]));
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid Email or Password',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function refresh()
    {
        $payload = auth()->payload();
        $token = auth()->refresh();
        return response()->json(api_resualt_common([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expire_at' => $payload('exp'),
            'user' => Auth::user()
        ]));
    }

    public function me()
    {
        return response()->json(api_resualt_common([
            'user' => Auth::user()
        ]));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(api_resualt_common([
            'message' => 'User logged out successfully'
        ]));
    }
}
