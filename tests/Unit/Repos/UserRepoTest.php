<?php

namespace Tests\Unit\Repos;

use App\Models\User;
use App\Repos\UserRepo;
use Tests\UnitTestCase;

class UserRepoTest extends UnitTestCase
{
    /**
     * @var UserRepo
     */
    protected $userRepo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepo = $this->app->make(UserRepo::class);
    }

    public function test_register_user()
    {
        $userData = [
            'username' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];

        $user = $this->userRepo->registerUser($userData);

        $this->assertDatabaseHas(User::class, $userData);

        $this->assertEquals($userData['username'], $user->username);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertEquals($userData['password'], $user->password);
    }

    public function test_get_first_by_email()
    {
        $email = $this->faker->unique()->email;

        User::factory()->create(['email' => $email]);
        User::factory()->create(['email' => $this->faker->unique()->email]);

        $user = $this->userRepo->getFirstByEmail($email);

        $this->assertEquals($email, $user->email);
    }

    public function test_clear_remember_token()
    {
        $email = $this->faker->unique()->email;

        $user = User::factory()->create([
            'email' => $email,
            'remember_token' => $this->faker->password,
        ]);

        $this->userRepo->clearRememberToken($email);

        $response = User::findOrFail($user->id);

        $this->assertEquals($response->remember_token, null);
    }
}
