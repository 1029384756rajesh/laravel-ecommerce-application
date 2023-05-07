<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            "name" => "required|min:2|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|max:20"
        ]);

        $data["password"] = Hash::make($data["password"]);

        $user = User::create($data);

        Auth::login($user);

        return redirect()->intended('/');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->onlyInput('email');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            "name" => "required|min:2|max:30",
            "email" => "required|email|max:40|unique:users,email,$user->id"
        ]);

        $user->update($data);

        return back()->with("success", "Account updated successfully");
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

        return back()->with("success", "Password changed successfully");
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        return redirect("/")->with("success", "Password changed successfully");
    }
}
