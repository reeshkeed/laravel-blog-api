<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class RegisterTest extends TestCase
{
    public function testsRegistersSuccessfully()
    {
        $payload = [
            'name' => 'John Doe',
            'username' => 'john',
            'email' => 'john@testuser.com',
            'password' => 'john123'
        ];

        $this->json('POST', '/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'username',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'token'
            ]);;
    }

    public function testsRequiresPasswordEmailAndName()
    {
        $this->json('POST', '/api/register')
            ->assertStatus(400)
            ->assertJson([
                'error'=> [
                    'name' => ['The name field is required.'],
                    'username' => ['The username field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }
}
