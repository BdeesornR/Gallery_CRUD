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

        return ['email' => $validated['email'], 'username' => $validated['name']];
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        session()->invalidate();
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $validated['persist'])) {
            Auth::logoutOtherDevices($validated['password']);
            $user = Auth::user();
            return ['email' => $user['email'], 'username' => $user['username']];
        } else {
            abort(401,'Unauthorized');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $user = User::where('email', $request->email)->first();
        if ($user->remember_token) {
            $user->remember_token = null;
            $user->save();
        }
        session()->invalidate();
    }

    public function get_user()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return ['email' => $user['email'], 'username' => $user['username']];
        } else {
            abort(401,'Unauthorized');
        }
    }
}
