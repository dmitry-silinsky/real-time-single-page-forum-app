<?php

namespace Tests\Feature;

use App\Models\{Question, Reply, User};
use Illuminate\Foundation\Testing\{DatabaseTransactions, WithFaker};
use Illuminate\Http\Response;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * @return void
     */
    public function testIndexSuccess()
    {
        $question = factory(Question::class)->create();
        factory(Reply::class, 10)->create(['question_id' => $question]);

        $response = $this->getJson(route('question.reply.index', $question));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testShowSuccess()
    {
        $question = factory(Question::class)->create();
        factory(Reply::class, 10)->create(['question_id' => $question]);

        $reply = $question->fresh('replies')->replies()->inRandomOrder()->first();

        $response = $this->getJson(route('question.reply.index', [$question, $reply]));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testStoreSuccess()
    {
        /** @var Question $question */
        $question = factory(Question::class)->create();

        $response = $this->postJson(
            route('question.reply.store', $question),
            [
                'body' => $body = $this->faker->text,
            ],
            ['Authorization' => "Bearer {$this->getToken()}"]
        );
        $response->assertStatus(Response::HTTP_CREATED);

        $question->refresh();

        $this->assertCount(1, $question->replies);
        $reply = $question->replies->first();
        $this->assertEquals($body, $reply->body);
    }

    /**
     * @return void
     */
    public function testUpdateSuccess()
    {
        $user = factory(User::class)->create();

        /** @var Question $question */
        $question = factory(Question::class)->create();
        /** @var Reply $reply */
        $reply = factory(Reply::class)->create([
            'question_id' => $question,
            'user_id' => $user,
        ]);

        $response = $this->putJson(
            route('question.reply.update', [$question, $reply]),
            ['body' => $body = $this->faker->text],
            ['Authorization' => "Bearer {$this->getToken($user)}"]
        );
        $response->assertStatus(Response::HTTP_ACCEPTED);

        $question->refresh();

        $this->assertEquals($body, $reply->refresh()->body);
    }

    /**
     * @return void
     */
    public function testDeleteSuccess()
    {
        $question = factory(Question::class)->create();
        $reply = factory(Reply::class)->create(['question_id' => $question]);

        $response = $this->deleteJson(
            route('question.reply.destroy', [$question, $reply]),
            [],
            ['Authorization' => "Bearer {$this->getToken($reply->user)}"]
        );
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $reply = Reply::find($reply->id);
        $this->assertNull($reply);
        $this->assertEmpty($question->refresh()->replies);
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
