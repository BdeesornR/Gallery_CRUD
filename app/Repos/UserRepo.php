<?php

namespace App\Repos;

use App\Models\User;

class UserRepo
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function registerUser(array $userData): User
    {
        $this->user->username = $userData['username'];
        $this->user->email = $userData['email'];
        $this->user->password = $userData['password'];

        $this->user->save();

        return $this->user;
    }

    public function getFirstByEmail(string $email): User
    {
        return $this->user->where('email', $email)->first();
    }

    public function clearRememberToken(string $email): void
    {
        $user = $this->getFirstByEmail($email);
        $user->remember_token = null;
        $user->save();
    }
}