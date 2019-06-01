<?php

namespace App\Models;

use DomainException;
use Eloquent;
use Illuminate\Database\Eloquent\{Builder, Collection, Model, Relations};
use Illuminate\Support\Carbon;

/**
 * App\Models\Reply
 *
 * @property int $id
 * @property string $body
 * @property int $question_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Like[] $likes
 * @property-read Question $question
 * @property-read User $user
 * @method static Builder|Reply newModelQuery()
 * @method static Builder|Reply newQuery()
 * @method static Builder|Reply query()
 * @method static Builder|Reply whereBody($value)
 * @method static Builder|Reply whereCreatedAt($value)
 * @method static Builder|Reply whereId($value)
 * @method static Builder|Reply whereQuestionId($value)
 * @method static Builder|Reply whereUpdatedAt($value)
 * @method static Builder|Reply whereUserId($value)
 * @mixin Eloquent
 */
class Reply extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $with = ['likes'];

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

    /**
     * @param User $user
     * @return bool
     */
    public function likedByUser(User $user): bool
    {
        return (bool)$this->likes->where('user_id', $user->id)->count();
    }

    /**
     * @param User $user
     * @return void
     * @throws DomainException
     */
    public function like(User $user)
    {
        if ($this->likes()->where('user_id', $user->id)->first()) {
            throw new DomainException('This reply already liked this user');
        }

        $this->likes()->create(['user_id' => $user->id]);
    }

    /**
     * @param User $user
     * @return void
     */
    public function unlike(User $user)
    {
        if (! $this->likes()->where('user_id', $user->id)->first()) {
            throw new DomainException('Like of this user not found');
        }

        $this->likes()->where('user_id', $user->id)->delete();
    }
}
