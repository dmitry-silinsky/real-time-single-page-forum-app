<?php

use App\Models\{Like, Reply, User};
use Illuminate\Database\Seeder;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Reply::class, 50)->create()->each(function (Reply $reply) {
            $user = User::where('id', '!=', $reply->user_id)
                ->inRandomOrder()
                ->first();

            factory(Like::class, mt_rand(0, 20))->create([
                'reply_id' => $reply,
                'user_id' => $user,
            ]);
        });
    }
}
