<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\VerificationToken;
use App\Models\ForgotToken;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['currentUser' => $request->user()]);
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $authToken = Auth::attempt([
            'email' => $user->email,
            'password' => $request->password,
        ]);

        $verificationToken = sha1(time());
        
        VerificationToken::create([
            'email' => $request->email,
            'token' => $verificationToken
        ]);

        return response()->json([
            'user' => $user,
            'authToken' => $authToken,
            'tokenType' => 'bearer',
            'expiresIn' => auth()->factory()->getTTL() * 60,
            'verificationToken' => $verificationToken
        ]);
    }

    public function resendVerificationLink(Request $request)
    {
        $verificationToken = sha1(time());
        
        VerificationToken::create([
            'email' => $request->user()->email,
            'token' => $verificationToken
        ]);

        return response()->json(['verificationToken' => $verificationToken]);
    }

    public function verifyAccount(Request $request, $token)
    {
        $tokenRow = VerificationToken::where('token', $token)->first();

        if(!$tokenRow)
        {
            return response()->json(['error' => 'Link invalid or expired'], 400);
        }

        $user = User::where('email', $tokenRow->email)->first();
        
        if($user)
        {
            $user->is_verified = true;
            $user->save();
            $tokenRow->delete();
        }

        return response()->json(['message' => 'Account verified successfully']);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $resetToken = sha1(time());

        ForgotToken::create([
            'email' => $request->email,
            'token' => $resetToken
        ]);

        return response()->json(['resetToken' => $resetToken]);
    }

    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'newPassword' => 'required|min:6|max:20'
        ]);

        $tokenRow = ForgotToken::where('token', $token)->first();

        if(!$tokenRow)
        {
            return response()->json(['error' => 'Token invalid or expired'], 400);
        }

        $user = User::where('email', $tokenRow->email)->first();

        if($user)
        {
            $user->password = Hash::make($request->newPassword);
            $user->save();
            $tokenRow->delete();
        }

        return response()->json(['success' => 'Password changed successfully']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $token = Auth::attempt($credentials);

        if (!$token) 
        {
            return response()->json(['error' => 'Unauthorized'], 400);
        }

        return response()->json([
            'authToken' => $token,
            'tokenType' => 'bearer',
            'expiresIn' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function editAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:30'
        ]);

        $user = $request->user();

        $user->name = $request->name;

        $user->save();

        return response()->json($user);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required|current_password',
            'newPassword' => 'required|min:6|max:20' 
        ]);

        $user = $request->user();

        $user->password = Hash::make($request->newPassword);
        
        $user->save();

        return response()->json(['success' => 'Password changed successfully']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        return response()->json(['success' => 'Logging ou successfully']);
    }
}
