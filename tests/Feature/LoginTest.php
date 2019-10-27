<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{
    public function testRequiresUsernameAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(400)
            ->assertJson([
                'error' => 'invalid_credentials'
            ]);
    }


    public function testUserLoginsSuccessfully()
    {
        $user = factory(User::class)->create([
            'username' => 'testlogin',
            'password' => bcrypt('testlogin123'),
        ]);

        $payload = ['username' => 'testlogin', 'password' => 'testlogin123'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);

    }
}
