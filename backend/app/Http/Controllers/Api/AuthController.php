<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:sanctum', ['except' => ['register', 'login']]);
    }
    
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        // Check if the user exists
        if (!$user) {
            return response()->json([
                'message' => 'User with this email does not exist.'
            ], 404); // 404 Not Found status code
        }

        // Check if the password is correct
        if (!Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Incorrect password. Please try again.'
            ], 401); // 401 Unauthorized status code
        }

        // Password is correct, proceed with login
        $token = $user->createToken('main')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }


    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $token = $user->createToken('main')->plainTextToken;

            Mail::to($user->email)->send(new EmailVerify($user)); // Pass user ID to EmailVerify constructor

            return response()->json([
                'status' => 200,
                'message' => 'Registered, verify your email address to login',
            ], 200);
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            $user->delete();
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while registering.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response('', 204);
    }
}
