<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(AuthRequest $request)
    {
        $data = $request->validated();

        if (!auth()->attempt($data)) {
            return response(['status' => 'fail', 'message' => 'Incorrect Details. Please try again'], 422);
        }

        $token = auth()->user()->createToken('authToken')->accessToken;

        return response(['status' => 'success', 'user' => auth()->user(), 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return response(['status' => 'success', 'message' => 'You have been successfully logged out!']);
    }
}
