<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $user = User::where('id', $request->route('id'))->first();
    
        if (!$user) {
            return redirect()->route('verification.user_not_found');
        }
    
        if (!$request->hasValidSignature()) {
            return redirect()->route('verification.invalid_link');
        }
    
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return redirect()->route('verification.success', ['email' => $user->email]);
        } else {
            return redirect()->route('verification.already_verified');
        }
    }

    
    public function success(Request $request)
    {
        return view('verification.success', ['email' => $request->email]);
    }
    
    public function alreadyVerified()
    {
        return view('verification.already_verified');
    }
    
    public function userNotFound()
    {
        return view('verification.user_not_found');
    }
    
    public function invalidLink()
    {
        return view('verification.invalid_link');
    }

}
