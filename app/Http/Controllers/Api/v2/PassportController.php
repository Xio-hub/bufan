<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::guard('merchant')->attempt($credentials)) {
            $token = Auth::guard('merchant')->user()->createToken('BuFanUser')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->delete();
        return response()->json(['status' => 200, 'message' => '登出成功']);
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request)
    {
        $user = $request->user();
        $data = [
            'id' => $user->id,
            'username'=> $user->username,
            'expired_at' => $user->expired_at
        ];
        
        return response()->json($data);
    }
}
