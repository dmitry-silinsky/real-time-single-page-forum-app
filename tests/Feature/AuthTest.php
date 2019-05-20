<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\{DatabaseTransactions, WithFaker};
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * @return void
     */
    public function testLoginSuccess()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    /**
     * @return void
     */
    public function testRefreshSuccess()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $token = $response->json(['access_token']);

        $response = $this->postJson(route('auth.refresh'), ['token' => $token]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    /**
     * @return void
     */
    public function testGetUserSuccess(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $token = $response->json(['access_token']);

        $response = $this->postJson(route('auth.me'), ['token' => $token]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at'
        ]);
    }

    /**
     * @return void
     */
    public function testLogoutSuccess(): void
    {
        factory(User::class)->create(['email' => $email = $this->faker->email]);
        $token = auth('api')->attempt(['email' => $email, 'password' => 'password']);

        $response = $this->postJson(route('auth.logout'), [], ['Authorization' => "Bearer $token"]);
        $response->assertStatus(Response::HTTP_OK);
    }
}
