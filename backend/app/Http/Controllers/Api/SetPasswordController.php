<?php


namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8', // Add minimum length for password
            'token' => 'required'
        ]);

        // Check if the token is valid
        $tokenExists = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->exists();

        // if (!$tokenExists) {
        //     return response()->json(['message' => 'Invalid token'], 400);
        // }

        // Update user's password
        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        // Remove the used token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }
}
