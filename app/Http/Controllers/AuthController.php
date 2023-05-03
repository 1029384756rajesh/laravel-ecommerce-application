<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function user(Request $request)
    {
        return response()->json(["currentUser" => $request->user()]);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            "name" => "required|min:2|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|max:20"
        ]);

        $data["password"] = Hash::make($data["password"]);

        $user = User::create($data);

        $token = auth()->attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        return response()->json(["token" => $token]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $token = auth()->attempt($credentials);

        if($token) return response()->json(["token" => $token]);

        return response()->json(["error" => "Invalid email or password"], 422);
    }

    public function edit(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            "name" => "required|min:2|max:30",
            "email" => "required|email|max:40|unique:users,email,$user->id"
        ]);

        $user->update($data);

        return response()->json($user);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            "old_password" => "required|current_password",
            "new_password" => "required|min:6|max:20" 
        ]);

        $user = $request->user();

        $user->password = Hash::make($request->new_password);
        
        $user->save();

        return response()->json(["success" => "Password changed successfully"]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
 
        return response()->json(["success" => "Logout successfull"]);
    }
}
