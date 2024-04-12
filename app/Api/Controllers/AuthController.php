<?php

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Api\Requests\Auth\RegisterRequest;
use App\Api\Requests\Auth\LoginRequest;
use Auth;
use JWTAuth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                $credentials = $request->only('email', 'password');
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'status_code' => 400,
                        'message'     => 'Incorrect email address or password'
                    ], 400);
                }
            }
            $user = \Auth::user();
            return response()->json([   
                'status_code' => '200',
                'data'        => $user,
                'token'       => $token,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status_code' => 500, 
                'message'     => 'Could not create token'
            ], 500);
        }
    }

    public function signup(RegisterRequest $request)
    {
        try {
            $data = $request->only(['name','email','password']);
            $emailExist = User::where('email', $data['email'])->first();
            if($emailExist){
                return response()->json([
                    'status_code' => 400,
                    'message'     => 'Email is already taken',
                ], 400);
            }

            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            $token = \JWTAuth::fromUser($user);

            return response()->json([
                'status_code' => 200,
                'data'        => $user,
                'token'       => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message'     => 'An error occurred',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate();
            } catch (\Exception $e) {

                return response()->json([
                    'status_code' => 500,
                    'error' => 'Failed to logout'
                ]);
            }
            return response()->json([
                'status_code' => 200,
                'message' => 'User logged out successfully'
            ]);
        }
        return response()->json([
            'status_code' => 401,
            'error' => 'Unauthorized'
        ]);
    }
}
