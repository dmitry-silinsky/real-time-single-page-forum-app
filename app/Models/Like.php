<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations};

/**
 * App\Models\Like
 *
 * @property int $id
 * @property int $reply_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Reply $reply
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereReplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereUserId($value)
 * @mixin \Eloquent
 */
class Like extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return Relations\BelongsTo
     */
    public function reply()
    {
        return $this->belongsTo(Reply::class);
    }

    /**
     * @return Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
