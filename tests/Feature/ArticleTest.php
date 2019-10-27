<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Articles;
use App\User;

class ArticleTest extends TestCase
{
    public function testsArticlesAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'title' => 'Lorem',
            'description' => 'Ipsum',
        ];


        $this->json('POST', '/api/articles', $payload, $headers)
            ->assertStatus(201)
            ->assertJson(['title' => 'Lorem', 'description' => 'Ipsum']);
    }

    public function testsArticlesAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $article = factory(Articles::class)->create([
            'title' => 'First Article',
            'description' => 'First Description',
        ]);

        $payload = [
            'title' => 'Lorem',
            'description' => 'Ipsum',
        ];

        $response = $this->json('PUT', '/api/articles/' . $article->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'title' => 'Lorem',
                'description' => 'Ipsum'
            ]);
    }

    public function testsArtilcesAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $article = factory(Articles::class)->create([
            'title' => 'First Article',
            'description' => 'First Description',
        ]);

        $this->json('DELETE', '/api/articles/' . $article->id, [], $headers)
            ->assertStatus(204);
    }

    public function testArticlesAreListedCorrectly()
    {
        factory(Articles::class)->create([
            'title' => 'First Article',
            'description' => 'First Description'
        ]);

        factory(Articles::class)->create([
            'title' => 'Second Article',
            'description' => 'Second Description'
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/articles', [], $headers)
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'First Article', 'description' => 'First Description'
            ])
            ->assertJsonFragment([
                'title' => 'Second Article', 'description' => 'Second Description'
            ])
            ->assertJsonStructure([
                '*' => ['id', 'description', 'title', 'created_at', 'updated_at'],
            ]);
    }

}
