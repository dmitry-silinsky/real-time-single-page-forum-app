<?php

namespace Tests\Feature;

use App\Models\{Category, Question, User};
use Illuminate\Foundation\Testing\{DatabaseTransactions, WithFaker};
use Illuminate\Http\Response;
use Str;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * @return void
     */
    public function testIndexSuccess()
    {
        $this->getJson(route('question.index'))->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testShowSuccess()
    {
        $question = factory(Question::class)->create();

        $this->getJson(route('question.show', $question))->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testStoreSuccess()
    {
        /** @var Category $category */
        $category = Category::inRandomOrder()->first();

        $response = $this->postJson(
            route('question.store'),
            [
                'title' => $title = $this->faker->sentence,
                'body' => $body = $this->faker->text,
                'category_id' => $category->id,
            ],
            ['Authorization' => "Bearer {$this->getToken()}"]
        );
        $response->assertStatus(Response::HTTP_CREATED);

        $question = Question::whereTitle($title)->first();
        $this->assertNotNull($question);
        $this->assertEquals($title, $question->title);
        $this->assertEquals(Str::slug($title), $question->slug);
        $this->assertEquals($body, $question->body);
        $this->assertTrue($question->category->is($category));
    }

    /**
     * @return void
     */
    public function testUpdateSuccess()
    {
        $question = factory(Question::class)->create();

        $response = $this->putJson(
            route('question.update', $question),
            [
                'title' => $title = $this->faker->sentence,
                'body' => $body = $this->faker->text,
            ],
            ['Authorization' => "Bearer {$this->getToken($question->user)}"]
        );
        $response->assertStatus(Response::HTTP_ACCEPTED);

        $question = Question::whereTitle($title)->first();
        $this->assertNotNull($question);
        $this->assertEquals($title, $question->title);
        $this->assertEquals(Str::slug($title), $question->slug);
        $this->assertEquals($body, $question->body);
        $this->assertTrue($question->category->is($question->category));
        $this->assertTrue($question->user->is($question->user));
    }

    /**
     * @return void
     */
    public function testDeleteSuccess()
    {
        /** @var Question $question */
        $question = factory(Question::class)->create();

        $response = $this->deleteJson(
            route('question.destroy', $question),
            [],
            ['Authorization' => "Bearer {$this->getToken()}"]
        );
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNull(Question::find($question->slug));
    }

    /**
     * @param User|null $user
     * @param string $password
     * @return bool|string
     */
    private function getToken(User $user = null, string $password = 'password')
    {
        if ($user) {
            return auth('api')->attempt(['email' => $user->email, 'password' => $password]);
        }

        factory(User::class)->create([
            'email' => $email = $this->faker->email,
            'password' => $password
        ]);
        return auth('api')->attempt(['email' => $email, 'password' => $password]);
    }
}
