<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LogoutTest extends TestCase
{
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('POST', '/api/logout', [], $headers)->assertStatus(405);

        $user = User::find($user->id);
    }

    public function testUserWithLoggedOutToken()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('GET', '/api/logout', [], $headers);

        $this->json('GET', '/api/logout', [], $headers)
            ->assertJson([
                'status' => 'Token is Invalid'
            ]);

    }
}
