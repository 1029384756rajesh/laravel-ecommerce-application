<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
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

        $token = Auth::attempt([
            'email' => $user->email,
            'password' => $user->password,
        ]);

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
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
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function editAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:30',
            'email' => 'required|email|unique:users,email,' . $request->user()->id
        ]);

        $user = $request->user();

        $user->name = $request->name;

        $user->email = $request->email;

        $user->save();

        return response()->json($user);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|min:6|max:20|confirmed' 
        ]);

        $user = $request->user();

        $user->password = Hash::make($request->new_password);
        
        $user->save();

        return response()->json(['success', 'Password changed successfully']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        return response()->json(['success', 'Logging ou successfully']);
    }
}
