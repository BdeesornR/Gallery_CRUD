<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

class UserControllerTest extends UnitTestCase
{
    public function test_register()
    {
        $userPayload = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $response = $this->postJson(route('register'), $userPayload);

        $response->assertStatus(200);
        $response->assertExactJson([
            'user_id' => 1,
            'username' => $userPayload['name'],
        ]);

        $this->assertTrue(Auth::check());

        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseHas(User::class, ['username' => $userPayload['name'], 'email' => $userPayload['email']]);
    }

    public function test_login()
    {
        $password = 'secret';

        $user = User::factory()->create(['password' => bcrypt($password)]);

        $userPayload = [
            'email' => $user->email,
            'password' => $password,
            'persist' => false,
        ];

        $response = $this->postJson(route('login'), $userPayload);

        $response->assertStatus(200);
        $response->assertExactJson([
            'user_id' => $user->id,
            'username' => $user->username,
        ]);

        Auth::logout();

        $userPayload['password'] = 'wrongPassword';

        $this->withoutExceptionHandling();
        $this->expectException("Exception");
        $this->expectExceptionMessage("There's no such user");
        
        $this->postJson(route('login'), $userPayload);
    }

    public function test_logout()
    {
        $user = User::factory()->create();

        Auth::login($user, true);

        $this->postJson(route('logout'));

        $this->assertDatabaseMissing($user, ['remember_token']);
        $this->assertFalse(Auth::check());
        $this->assertFalse(Auth::viaRemember());
    }

    public function test_get_user_when_unauthenticated()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Exception');
        $this->expectExceptionMessage("Unauthenticated");

        $this->getJson(route('getUser'));
    }

    public function test_get_user_when_logged_in()
    {
        $user = User::factory()->create();

        Auth::login($user);

        $response = $this->getJson(route('getUser'));

        $response->assertStatus(200);
        $response->assertExactJson([
            'user_id' => $user->id,
            'username' => $user->username,
        ]);
    }
}
