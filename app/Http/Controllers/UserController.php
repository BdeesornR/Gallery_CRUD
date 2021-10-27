<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = new User();

        $encryptPassword = Hash::make($validated['password']);

        $user->username = $validated['name'];
        $user->email = $validated['email'];
        $user->password = $encryptPassword;

        $user->save();
    }

    public function show(LoginRequest $request) {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->firstOrFail();

        if (Hash::check($validated['password'], $user->password)) {
            return "Success";
        } else {
            return "Fail";
        }
    }


}
