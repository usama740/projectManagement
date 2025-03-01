<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\CustomResponse;
use App\Http\Requests\LoginRequest;


class LoginController extends Controller
{
    // Handle user login
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(
                CustomResponse::send(401, "Unauthorized", [], false),
                401
            );
        }

        $user = Auth::user();
        $token = $user->createToken('API Token', [], $user->getAccessTokenPayload())->accessToken;

        return response()->json(
            CustomResponse::send(200, "Successfully logged in", ['token' => $token])
        );
    }

    // Handle user logout
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(
                CustomResponse::send(401, "Unauthorized", [], false),
                401
            );
        }

        $user->token()->revoke();

        return response()->json(
            CustomResponse::send(200, "Successfully logged out", [], false)
        );
    }
}


