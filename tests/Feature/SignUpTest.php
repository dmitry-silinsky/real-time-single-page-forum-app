<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\{DatabaseTransactions, WithFaker};
use Illuminate\Http\Response;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * @return void
     */
    public function testSignUpSuccess(): void
    {
        $response = $this->postJson(route('auth.signUp'), [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $password = $this->faker->password(6),
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']);

        /** @var User $user */
        $user = User::whereEmail($email)->first();

        $this->assertNotNull($user);
        $this->assertEquals($name, $user->name);
        $this->assertNotEquals($password, $user->password);
    }
}
