<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request) :array
    {
        $validated = $request->validated();
        $encryptPassword = Hash::make($validated['password']);

        $user = new User();

        $user->username = $validated['name'];
        $user->email = $validated['email'];
        $user->password = $encryptPassword;

        $user->save();

        Auth::login($user);

        return ['email' => $validated['email'], 'username' => $validated['name']];
    }

    public function login(LoginRequest $request) :array
    {
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $validated['persist'])) {
            Auth::logoutOtherDevices($validated['password']);
        }

        $user = Auth::user();

        if ($user) {
            return ['email' => $user['email'], 'username' => $user['username']];
        } else {
            return ['email' => null, 'username' => null];
        }
    }

    public function logout(Request $request) :void
    {
        Auth::logout();
        $user = User::where('email', $request->email)->first();
        if ($user->remember_token) {
            $user->remember_token = null;
            $user->save();
        }
    }

    public function get_user() :array
    {
        Auth::check();
        $user = Auth::user();

        if ($user) {
            return ['email' => $user['email'], 'username' => $user['username']];
        } else {
            return ['email' => null, 'username' => null];
        }
    }
}
