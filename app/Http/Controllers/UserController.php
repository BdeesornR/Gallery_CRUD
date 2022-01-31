<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repos\UserRepo;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(RegisterRequest $request): array
    {
        $userData = [
            'username' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ];

        $user = DB::transaction(function () use ($userData) {
            $user = $this->userRepo->registerUser($userData);
            Auth::login($user);
            return $user;
        });

        return ['user_id' => $user->id, 'username' => $user->username];
    }

    public function login(LoginRequest $request): array
    {
        if (Auth::attempt(
            [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ],
            $request->input('persist')
        )) {
            Auth::logoutOtherDevices($request->input('password'));
        } else {
            throw new Exception("There's no such user");
        }

        $user = $this->userRepo->getFirstByEmail($request->input('email'));

        return ['user_id' => $user->id, 'username' => $user->username];
    }

    public function logout(): void
    {
        DB::transaction(function () {
            Auth::logout();
            $this->userRepo->clearRememberToken(Auth::user()['email']);
        });
    }

    public function getUser(): array
    {
        if (!Auth::check()) {
            throw new Exception("There's no such user");
        }

        $user = $this->userRepo->getFirstByEmail(Auth::user()['email']);

        return ['user_id' => $user->id, 'username' => $user->username];
    }
}
