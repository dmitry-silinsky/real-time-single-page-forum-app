<?php

namespace Tests\Unit\Models;

use App\Models\{Like, Reply, User};
use DomainException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testLikeSuccess()
    {
        /** @var Reply $reply */
        $reply = factory(Reply::class)->create();
        /** @var User $user */
        $user = factory(User::class)->create();

        $reply->like($user);

        $reply->refresh();

        $this->assertCount(1, $reply->likes);

        /** @var Like $like */
        $like = $reply->likes->first();
        $this->assertTrue($like->user->is($user));

        $this->expectException(DomainException::class);
        $reply->like($user);
    }

    /**
     * @return void
     */
    public function testUnlikeSuccess()
    {
        /** @var Reply $reply */
        $reply = factory(Reply::class)->create();
        /** @var User $user */
        $user = factory(User::class)->create();

        $reply->like($user);

        $reply->refresh();
        $this->assertCount(1, $reply->likes);

        $reply->unlike($user);

        $reply->refresh();

        $this->assertEmpty($reply->likes);
    }

    /**
     * @return void
     */
    public function testUnlikeError()
    {
        /** @var Reply $reply */
        $reply = factory(Reply::class)->create();
        /** @var User $user */
        $user = factory(User::class)->create();

        $this->expectException(DomainException::class);
        $reply->unlike($user);
    }
}
