<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations};

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property int $category_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reply[] $replies
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereUserId($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

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
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * @return Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
