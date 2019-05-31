<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\{Builder, Collection, Model, Relations};
use Illuminate\Support\Carbon;
use Str;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property int $category_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $path
 * @property-read Category $category
 * @property-read Collection|Reply[] $replies
 * @property-read User $user
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 * @method static Builder|Question whereBody($value)
 * @method static Builder|Question whereCategoryId($value)
 * @method static Builder|Question whereCreatedAt($value)
 * @method static Builder|Question whereId($value)
 * @method static Builder|Question whereSlug($value)
 * @method static Builder|Question whereTitle($value)
 * @method static Builder|Question whereUpdatedAt($value)
 * @method static Builder|Question whereUserId($value)
 * @mixin Eloquent
 */
class Question extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
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
    public function replies()
    {
        return $this->hasMany(Reply::class)->latest();
    }

    /**
     * @return Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return string
     */
    public function getPathAttribute()
    {
        return "/question/{$this->slug}";
    }

    /**
     * @return void
     */
    private function setSlug(): void
    {
        if (empty($this->title)) {
            throw new \DomainException('Empty title');
        }
        $this->slug = Str::slug($this->title);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $question) {
            $question->setSlug();
        });
    }
}
