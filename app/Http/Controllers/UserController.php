<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $encryptPassword = Hash::make($validated['password']);

        $user = new User();

        $user->username = $validated['name'];
        $user->email = $validated['email'];
        $user->password = $encryptPassword;

        $user->save();

        session()->invalidate();
        Auth::login($user);

        return ['email' => $validated['email']];
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        session()->invalidate();
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $validated['persist'])) {
            Auth::logoutOtherDevices($validated['password']);

            return ['email' => $validated['email']];
        } else {
            return "Login Failed";
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
    }
}
