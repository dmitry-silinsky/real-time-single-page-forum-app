<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations};

/**
 * App\Models\Reply
 *
 * @property int $id
 * @property string $body
 * @property int $question_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read \App\Models\Question $question
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereUserId($value)
 * @mixin \Eloquent
 */
class Reply extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
