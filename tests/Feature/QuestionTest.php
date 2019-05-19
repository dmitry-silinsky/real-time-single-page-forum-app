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
        $this->withoutExceptionHandling();

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
        /** @var User $user */
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->postJson(route('question.store'), [
            'title' => $title = $this->faker->sentence,
            'body' => $body = $this->faker->text,
            'category_id' => $category->id,
        ]);
        $response->assertStatus(Response::HTTP_CREATED);

        $question = Question::whereTitle($title)->first();
        $this->assertNotNull($question);
        $this->assertEquals($title, $question->title);
        $this->assertEquals(Str::slug($title), $question->slug);
        $this->assertEquals($body, $question->body);
        $this->assertTrue($question->category->is($category));
        $this->assertTrue($question->user->is($user));
    }

    /**
     * @return void
     */
    public function testUpdateSuccess()
    {
        $question = factory(Question::class)->create();

        $this->actingAs($question->user);

        $response = $this->putJson(route('question.update', $question), [
            'title' => $title = $this->faker->sentence,
            'body' => $body = $this->faker->text,
        ]);
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

        $this->deleteJson(route('question.destroy', $question))->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNull(Question::find($question->slug));
    }
}
