<?php

namespace Tests\Feature;

use App\Models\{Category, User};
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * @return void
     */
    public function testIndexSuccess()
    {
        $this->getJson(route('category.index'))->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testShowSuccess()
    {
        $category = factory(Category::class)->create();

        $this->getJson(route('category.show', $category))->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testStoreSuccess()
    {
        $response = $this->postJson(
            route('category.store'),
            ['name' => $name = $this->faker->sentence],
            ['Authorization' => "Bearer {$this->getToken()}"]
        );
        $response->assertStatus(Response::HTTP_CREATED);

        $category = Category::whereName($name)->first();
        $this->assertNotNull($category);
        $this->assertEquals($name, $category->name);
        $this->assertEquals(Str::slug($name), $category->slug);
    }

    /**
     * @return void
     */
    public function testUpdateSuccess()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $response = $this->putJson(
            route('category.update', $category),
            ['name' => $name = $this->faker->sentence],
            ['Authorization' => "Bearer {$this->getToken()}"]
        );
        $response->assertStatus(Response::HTTP_ACCEPTED);

        $category = Category::whereName($name)->first();
        $this->assertNotNull($category);
        $this->assertEquals($name, $category->name);
        $this->assertEquals(Str::slug($name), $category->slug);
    }

    /**
     * @return void
     */
    public function testDeleteSuccess()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $this
            ->deleteJson(
                route('category.destroy', $category),
                [],
                ['Authorization' => "Bearer {$this->getToken()}"]
            )
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNull(Category::find($category->slug));
    }

    /**
     * @return bool|string
     */
    private function getToken()
    {
        factory(User::class)->create([
            'email' => $email = $this->faker->email,
            'password' => $password = $this->faker->password(6)
        ]);
        return auth('api')->attempt(['email' => $email, 'password' => $password]);
    }
}
